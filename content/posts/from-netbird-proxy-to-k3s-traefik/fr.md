Après [la migration sur k3s](/blog/moving-my-server-to-k3s), tous mes services étaient des NodePort, et le reverse
proxy de NetBird pointait dessus. Ça marchait, mais le routage vivait en dehors du cluster : une nouvelle app,
c'était un manifest dans son repo, puis un détour par une autre interface pour lui donner un domaine. Cette
semaine j'ai tout basculé sur le Traefik fourni avec k3s.

## L'Ingress à côté de l'app

k3s embarque Traefik comme Ingress controller. Je l'avais désactivé en montant le cluster, donc première étape :
le réactiver. Petit piège : retirer `traefik` de la liste `disable:` dans la config de k3s ne suffisait pas, une
clé `disable:` vide le désactivait quand même. Il a fallu commenter toute la clé.

Maintenant chaque app porte sa propre route, dans le même fichier que son Deployment :

```yaml
apiVersion: networking.k8s.io/v1
kind: Ingress
metadata: {name: web}
spec:
  rules:
    - host: search.xalri.fr
      http:
        paths:
          - path: /
            pathType: Prefix
            backend: {service: {name: searxng, port: {number: 8080}}}
```

Le Service peut repasser en ClusterIP, plus de NodePort à suivre. Déployer l'app déploie son domaine, supprimer
le namespace le retire. C'est ça que j'aime : le routage n'est qu'un objet Kubernetes de plus, dans git, avec le
reste.

Quelques trucs ne sont pas dans k3s (Portainer, Proxmox, Jellyfin sur le NAS). Ceux-là sont dans une seule
ConfigMap que Traefik lit avec son file provider : un router et un service par cible, une IP et un port.

## Les certificats

Un wildcard pour `*.xalri.fr` (et pareil pour mon `.ovh`), via le challenge DNS Cloudflare, au lieu d'un
certificat par sous-domaine. Celui-là m'a pris du temps : le challenge partait en timeout à chaque fois. Tous mes
sous-domaines sont des CNAME vers le même hôte, et lego suit le CNAME avant de poser l'enregistrement TXT, du coup
il cherchait au mauvais endroit. `LEGO_DISABLE_CNAME_SUPPORT=true` et les résolveurs de Cloudflare, et c'était
réglé.

## Ce qui reste devant

Le Traefik de NetBird tient toujours les ports 80 et 443, parce que le serveur de management de NetBird en a
besoin. Mais il ne gère plus que `netbird.xalri.fr`. Tout le reste est transmis tel quel, TLS intact, au Traefik
de k3s, avec le proxy protocol pour que les apps voient toujours la vraie IP du client. C'est un catch-all : un
nouveau domaine ne demande aucun changement là-dessus, juste un enregistrement DNS et une Ingress.

Du coup NetBird revient à ce qu'il fait bien : le réseau privé. Il relie les deux nœuds du cluster et leur donne
accès au NAS et à mon réseau perso. Il n'expose plus rien sur internet.

Mon outil de CD a suivi : le manifest de départ qu'il propose pour une nouvelle app a maintenant une Ingress au
lieu d'un NodePort, et les previews de pull request ont leur propre host `pr-12-app.xalri.fr`.
