Until this week the site ran in Docker, managed by Portainer. Deploying was simple: I had put Portainer's webhook
URL directly in the GitHub repo's webhooks, so every push called it and Portainer redeployed. Nothing else.

I moved it to my k3s cluster, and that setup didn't carry over as is.

## What it looks like now

On every push to `main`, a GitHub Actions workflow builds the image and pushes it to ghcr.io. I tag it twice,
`main` and the commit hash, so I can always go back to a given version:

```yaml
tags: |
  ghcr.io/xalri/portfolio:main
  ghcr.io/xalri/portfolio:${{ github.sha }}
```

Then it calls Portainer's webhook, same as before, and Portainer applies `k8s/production.yaml` to the cluster.

## The site didn't update

First deploy: fine. Second one: the workflow was green, the new image was on ghcr.io, and the site was still the
old one.

It took me a moment. The manifest always says `image: ghcr.io/xalri/portfolio:main`, so for Kubernetes nothing
changed and there's nothing to roll out. `imagePullPolicy: Always` doesn't help either, it only applies when a pod
starts.

So I added [Keel](https://keel.sh). It watches Deployments with these annotations:

```yaml
annotations:
  keel.sh/policy: force
  keel.sh/match-tag: "true"
```

and the workflow calls it once the image is pushed:

```bash
curl -fsS -X POST "$KEEL" -H "Content-Type: application/json" \
  -d '{"name": "ghcr.io/xalri/portfolio", "tag": "main"}'
```

Keel restarts the pod, the pod pulls the new image, done. (I also forgot to add the Keel secret to the repo the
first time, so this exact post didn't show up until I did. Fitting.)

## The 403

The other surprise: in the container, every project page returned a 403.

There was an old `project/` folder in the site. Apache saw `/project`, found a folder with that name and tried to
list it, which is disabled. My rule that adds `.php` to URLs never ran, because it skips anything that exists on
disk. I deleted the folder and redirected its old URLs to the new page.

## Still to do

A proper health check instead of just checking the port is open, and running a PHP syntax check before building
the image. Everything is in the [repo](https://github.com/Xalri/portfolio) if you want to look.
