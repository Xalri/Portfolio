After [moving everything to k3s](/blog/moving-my-server-to-k3s), every service was a NodePort and the NetBird
reverse proxy pointed at those. It worked, but the routing lived outside the cluster: a new app meant a manifest
in its repo, then a trip to another UI to give it a domain. This week I moved all of that to the Traefik that
comes with k3s.

## Ingress next to the app

k3s ships Traefik as an Ingress controller. I had disabled it when I set up the cluster, so the first step was
turning it back on. Fun detail: removing `traefik` from the `disable:` list in the k3s config wasn't enough, an
empty `disable:` key still disabled it. I had to comment the whole key out.

Now each app carries its own route, in the same file as its Deployment:

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

The Service can go back to ClusterIP, no more NodePorts to keep track of. Deploying the app deploys its domain,
deleting the namespace removes it. That's the part I like: the routing is just another Kubernetes object, in git,
with the rest.

A few things aren't in k3s (Portainer, Proxmox, Jellyfin on the NAS). Those go in a single ConfigMap that Traefik
reads with its file provider: one router and one service per target, an IP and a port.

## Certificates

One wildcard for `*.xalri.fr` (and the same for my `.ovh`), through the Cloudflare DNS challenge, instead of one
certificate per subdomain. That one took a while: the challenge kept timing out. All my subdomains are CNAMEs to
the same host, and lego follows the CNAME before placing the TXT record, so it was looking in the wrong place.
`LEGO_DISABLE_CNAME_SUPPORT=true` and Cloudflare's resolvers fixed it.

## What's left in front

NetBird's own Traefik still sits on ports 80 and 443, because NetBird's management server needs it. But it only
handles `netbird.xalri.fr` now. Everything else is passed straight through, TLS untouched, to k3s Traefik, with
the proxy protocol so the apps still see the real client IP. It's a catch-all: a new domain doesn't need any
change there, just a DNS record and an Ingress.

So NetBird is back to what it's good at: the private network. It links the two nodes of the cluster and lets them
reach the NAS and my home network. It doesn't expose anything to the internet anymore.

My CD tool followed: the starter manifest it proposes for a new app now has an Ingress instead of a NodePort, and
pull request previews get their own `pr-12-app.xalri.fr` host.
