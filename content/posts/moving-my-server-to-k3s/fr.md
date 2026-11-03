Après [le portfolio](/blog/from-push-to-production), j'ai migré tout le reste. Nextcloud, Immich, Authentik,
Vaultwarden, Homarr, Umami, Uptime Kuma, Pterodactyl, Traccar, SearXNG, le serveur mail, le routeur Minecraft et
mes propres apps buildées depuis GitHub. Une vingtaine de stacks Portainer au total.

Docker ne me posait pas de problème. J'ai deux VPS, un chez OVH et un chez Oracle, et je voulais qu'ils forment un
seul cluster au lieu de deux hôtes Docker séparés. Et je voulais apprendre Kubernetes sur des trucs que j'utilise
vraiment.

## Pareil, en plus long

Pour l'instant Kubernetes me paraît plus lourd. La config est plus claire, et la partie vraiment propre à chaque
app est petite. Mais autour, il y a tout ce qu'on retape à chaque fois : un Deployment, un Service, des labels et
des selectors qui doivent correspondre, des PVC, un Secret. Un compose de quinze lignes devient un manifest de
quatre-vingts. Je sais que ça ira mieux quand je l'aurai dans les doigts, mais là, ça fait beaucoup à taper.

## Migrer les données

Les conteneurs, c'est la partie facile. La vraie migration, ce sont les données. Pour chaque stack, la même
chose : créer les PVC, lancer un petit pod busybox qui les monte, arrêter le conteneur Docker, puis copier le
volume dans le pod :

```bash
tar -C /var/lib/docker/volumes/<volume>/_data -cf - . \
  | kubectl exec -i -n <app> copy-helper -- tar -C /data -xf -
```

Ensuite un md5 de chaque fichier des deux côtés, comparés, avant de lancer l'app sur k3s. Arrêter le conteneur
avant compte : une base de données qui continue d'écrire pendant la copie, ça donne une copie qui a l'air bonne et
qui ne l'est pas. Long sur Immich, mais rien de perdu.

## Deux nœuds, deux architectures

Le nœud OVH est en amd64, celui d'Oracle en arm64, et ils se parlent via NetBird.

Certaines de mes images sont uniquement amd64. Kubernetes les a quand même placées sur le nœud arm, où elles
plantaient avec `no match for platform in manifest`. Un `nodeSelector` les garde sur le nœud OVH.

Le stockage, c'est l'autre piège. J'utilise le stockage local-path fourni avec k3s, donc un volume vit sur le
disque du nœud où il a été créé, et son pod reste bloqué dessus. « Utiliser les deux VPS », c'est vrai pour les
apps sans état, beaucoup moins pour Nextcloud.

## Les ports

Tout passe par des NodePorts, et le reverse proxy pointe dessus. Sauf le serveur mail et le routeur Minecraft, qui
gardent des hostPorts : les clients attendent 25, 993 ou 25565, pas 30xxx. Au passage, la config de mc-router est
devenue une ConfigMap.

## Ce qui a cassé

MongoDB, pour mes apps qui utilisent un replica set. Au démarrage, mongod doit se retrouver dans la config du
replica set par son nom, `mongodb`, mais ce nom ne résolvait qu'une fois le pod prêt, et le pod n'était prêt qu'une
fois le replica set lancé. `NodeNotFound` en boucle. Un Service headless avec `publishNotReadyAddresses: true`,
plus une entrée `hostAliases` qui fait pointer `mongodb` sur `127.0.0.1` dans le pod, et ça démarre.

Ensuite le disque. Les vieilles images Docker plus les nouvelles de k3s ont assez rempli le disque OVH pour que le
kubelet passe en disk pressure et évince des pods un peu partout. Un prune des images a réglé ça, mais
`crictl rmi --prune` a aussi supprimé l'image d'Obico que j'avais importée à la main, vu qu'aucun pod ne
l'utilisait à ce moment-là. La même image existait encore sous un autre tag, du coup un re-tag a suffi.

La copie Docker du serveur mail est toujours là, au cas où.
