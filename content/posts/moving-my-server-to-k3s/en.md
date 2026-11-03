After [the portfolio](/blog/from-push-to-production), I moved everything else. Nextcloud, Immich, Authentik,
Vaultwarden, Homarr, Umami, Uptime Kuma, Pterodactyl, Traccar, SearXNG, the mail server, the Minecraft router and
my own apps built from GitHub. About twenty-five Portainer stacks in total.

Docker wasn't a problem for me. What changed is that I got a second VPS, at Oracle, next to the OVH one. With two
machines I wanted one cluster rather than two separate Docker hosts, and it was the right moment to learn
Kubernetes on things I actually use.

## Same thing, more lines

Right now Kubernetes feels heavier. The config is clearer, and the part that's really specific to each app is
small. But around it there's everything you type again and again: a Deployment, a Service, labels and selectors
that have to match, PVCs, a Secret. A fifteen-line compose file becomes an eighty-line manifest. I know it gets
better once it's in my fingers, but for now it's a lot of typing.

## Moving the data

The containers are the easy part, the data is the actual migration. I did the same thing for every stack: create
the PVCs, start a small busybox pod that mounts them, stop the Docker container, and copy the volume into the pod:

```bash
tar -C /var/lib/docker/volumes/<volume>/_data -cf - . \
  | kubectl exec -i -n <app> copy-helper -- tar -C /data -xf -
```

Then an md5 of every file on both sides, compared, before starting the app on k3s. Stopping the container first
matters: a database that keeps writing during the copy gives you a copy that looks fine and isn't. It was slow on
Immich, but nothing got lost.

## Two nodes, two architectures

The OVH node is amd64, the Oracle one is arm64, and they talk over NetBird.

Some of my own images are amd64 only. Kubernetes happily put them on the arm node, where they failed with
`no match for platform in manifest`. A `nodeSelector` pins them to the OVH node.

Storage is the other catch. I use the local-path storage that comes with k3s, so a volume lives on the disk of the
node it was created on, and its pod is stuck there. "Using both VPS" is true for stateless apps, a lot less for
Nextcloud.

## Ports

Everything is a NodePort, and the reverse proxy points at those. Except the mail server and the Minecraft router,
which keep hostPorts: clients expect 25, 993 or 25565, not 30xxx. While I was at it, mc-router's config became a
ConfigMap.

## What broke

MongoDB, for my apps that use a replica set. On startup mongod has to find itself in the replica set config by
its name, `mongodb`, but that name only resolved once the pod was ready, and the pod was only ready once the
replica set was up. `NodeNotFound`, forever. A headless Service with `publishNotReadyAddresses: true`, plus a
`hostAliases` entry mapping `mongodb` to `127.0.0.1` in the pod, and it starts.

Then the disk. Old Docker images plus the new k3s ones filled the OVH disk enough for the kubelet to declare disk
pressure and evict pods all over the cluster. Pruning images fixed it, but `crictl rmi --prune` also removed the
Obico image I had imported by hand, since no running pod used it at that moment. The same image was still there
under another tag, so a re-tag brought it back.

The Docker copy of the mail server is still around, just in case.
