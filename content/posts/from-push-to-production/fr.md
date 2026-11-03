Jusqu'à récemment, mettre à jour ce site voulait dire copier des fichiers sur un serveur à la main. Maintenant, un
`git push` sur `main` suffit : environ deux minutes plus tard, la nouvelle version est en ligne. Voici comment ça
marche, et les deux choses qui ont cassé en chemin.

## Le pipeline

```text
git push ──▶ GitHub Actions ──▶ ghcr.io ──▶ Portainer ──▶ k3s
                                    └──────▶ Keel ───────▶ redémarrage
```

Trois briques :

1. **Une image Docker** avec PHP 8.4 et Apache, qui ne sert que le dossier `public/`.
2. **Un workflow GitHub Actions** qui construit cette image et la pousse sur le registre de GitHub.
3. **Mon cluster k3s**, sur un petit VPS, qui récupère l'image et la fait tourner.

## L'image

Le `Dockerfile` a deux étapes. La première installe les dépendances Composer, la seconde les copie à côté du code
dans l'image officielle `php:8.4-apache` :

```dockerfile
FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --prefer-dist

FROM php:8.4.27-apache
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
COPY --from=vendor /app/vendor vendor
COPY src src
COPY public public
```

Seul `public/` est accessible depuis le web : le code, le contenu et `vendor/` sont à côté, hors d'atteinte. Composer
lui-même ne finit jamais dans l'image finale.

## Le workflow

À chaque push sur `main`, le workflow construit l'image et la pousse avec deux tags : `main`, que le cluster fait
tourner, et le hash du commit, pour pouvoir toujours revenir à une version précise.

```yaml
tags: |
  ghcr.io/xalri/portfolio:main
  ghcr.io/xalri/portfolio:${{ github.sha }}
```

Ensuite il appelle le webhook de Portainer, qui applique `k8s/production.yaml` au cluster.

## Piège n°1 : rien n'a redémarré

Le premier déploiement a marché. Le deuxième… n'a rien fait. La nouvelle image était sur ghcr.io, Portainer disait
que la stack était à jour, et l'ancien site était toujours en ligne.

La raison : le manifeste indique toujours `image: ghcr.io/xalri/portfolio:main`. Pour Kubernetes, le Deployment
n'a pas changé du tout, donc il n'y a rien à déployer. `imagePullPolicy: Always` ne compte qu'au *démarrage* d'un
pod ; il ne redémarre pas ceux qui tournent.

La solution, c'est [Keel](https://keel.sh), un petit contrôleur qui redémarre un Deployment quand son image est
poussée à nouveau. Deux annotations sur le Deployment :

```yaml
annotations:
  keel.sh/policy: force
  keel.sh/match-tag: "true"
```

Et une dernière étape dans le workflow prévient Keel que l'image a été poussée :

```bash
curl -fsS -X POST "$KEEL" -H "Content-Type: application/json" \
  -d '{"name": "ghcr.io/xalri/portfolio", "tag": "main"}'
```

> Leçon : avec un tag qui bouge comme `main` ou `latest`, il faut que *quelque chose* déclenche le redémarrage.
> Kubernetes ne le fera pas tout seul.

## Piège n°2 : une 403 sur chaque page de projet

Une fois dans le conteneur, chaque page `/project?project=…` répondait **403 Forbidden**, alors qu'elles marchaient
avant.

Le site avait un vieux dossier `project/` dans `public/`. Apache voyait l'URL `/project`, trouvait un dossier de ce
nom, et essayait de le lister, ce que `Options -Indexes` interdit. Ma règle de réécriture qui ajoute `.php` n'était
jamais atteinte, parce qu'elle ignore tout ce qui existe sur le disque :

```apache
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME}.php -f
RewriteRule ^(.*[^/])/?$ $1.php [NC,L]
```

La solution : supprimer le dossier et rediriger ses anciennes URL vers la nouvelle page avec une `301`, pour que
les anciens liens marchent toujours.

## La suite

- [x] Déployer à chaque push
- [x] Garder une image par commit pour revenir en arrière
- [ ] Ajouter un vrai health check au lieu d'une sonde TCP
- [ ] Vérifier la syntaxe PHP dans le workflow avant de construire

Toute la configuration est dans le [dépôt](https://github.com/Xalri/portfolio) si vous voulez la reprendre.
