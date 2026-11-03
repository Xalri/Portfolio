Jusqu'à cette semaine, le site tournait sous Docker, géré par Portainer. Le déploiement était simple : j'avais mis
l'URL du webhook Portainer directement dans les webhooks du repo GitHub, donc chaque push l'appelait et Portainer
redéployait. Rien de plus.

Je l'ai passé sur mon cluster k3s, et ce fonctionnement ne suivait pas tel quel.

## Comment ça marche maintenant

À chaque push sur `main`, un workflow GitHub Actions build l'image et la pousse sur ghcr.io. Je la tag deux fois,
`main` et le hash du commit, pour pouvoir revenir à une version précise :

```yaml
tags: |
  ghcr.io/xalri/portfolio:main
  ghcr.io/xalri/portfolio:${{ github.sha }}
```

Ensuite il appelle le webhook Portainer, comme avant, et Portainer applique `k8s/production.yaml` au cluster.

## Le site ne se mettait pas à jour

Premier déploiement : nickel. Le deuxième : workflow au vert, nouvelle image sur ghcr.io, et toujours l'ancien site.

J'ai mis un moment à comprendre. Le manifeste dit toujours `image: ghcr.io/xalri/portfolio:main`, donc pour
Kubernetes rien n'a changé et il n'y a rien à redéployer. `imagePullPolicy: Always` n'aide pas non plus, ça ne
joue qu'au démarrage d'un pod.

Du coup j'ai ajouté [Keel](https://keel.sh). Il surveille les Deployments qui ont ces annotations :

```yaml
annotations:
  keel.sh/policy: force
  keel.sh/match-tag: "true"
```

et le workflow l'appelle une fois l'image poussée :

```bash
curl -fsS -X POST "$KEEL" -H "Content-Type: application/json" \
  -d '{"name": "ghcr.io/xalri/portfolio", "tag": "main"}'
```

Keel redémarre le pod, le pod récupère la nouvelle image, terminé. (J'avais aussi oublié d'ajouter le secret Keel
au repo la première fois, donc cet article n'apparaissait pas avant que je le fasse. Ironique.)

## La 403

L'autre surprise : dans le conteneur, toutes les pages de projet renvoyaient une 403.

Il restait un vieux dossier `project/` dans le site. Apache voyait `/project`, trouvait un dossier de ce nom et
essayait de le lister, ce qui est désactivé. Ma règle qui ajoute `.php` aux URL ne s'exécutait jamais, parce
qu'elle ignore tout ce qui existe sur le disque. J'ai supprimé le dossier et redirigé ses anciennes URL vers la
nouvelle page.

## Ce qu'il reste à faire

Un vrai health check au lieu de juste vérifier que le port répond, et un check de syntaxe PHP avant de build
l'image. Tout est sur le [repo](https://github.com/Xalri/portfolio) si vous voulez jeter un œil.
