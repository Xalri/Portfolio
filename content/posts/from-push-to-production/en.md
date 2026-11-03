Until recently, updating this site meant copying files to a server by hand. Now a `git push` on `main` is all it
takes: about two minutes later, the new version is live. Here is how it works, and the two things that broke
along the way.

## The pipeline

```text
git push ──▶ GitHub Actions ──▶ ghcr.io ──▶ Portainer ──▶ k3s
                                    └──────▶ Keel ───────▶ restart
```

Three pieces:

1. **A Docker image** with PHP 8.4 and Apache, serving only the `public/` folder.
2. **A GitHub Actions workflow** that builds that image and pushes it to GitHub's registry.
3. **My k3s cluster**, running on a small VPS, which pulls the image and runs it.

## The image

The `Dockerfile` has two stages. The first one installs the Composer dependencies, the second one copies them
next to the code in the official `php:8.4-apache` image:

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

Only `public/` is reachable from the web: the code, the content and `vendor/` sit next to it, out of reach. Composer
itself never ends up in the final image.

## The workflow

On each push to `main`, the workflow builds the image and pushes it with two tags: `main`, which the cluster
runs, and the commit hash, so I can always go back to an exact version.

```yaml
tags: |
  ghcr.io/xalri/portfolio:main
  ghcr.io/xalri/portfolio:${{ github.sha }}
```

Then it calls Portainer's webhook, which applies `k8s/production.yaml` to the cluster.

## Trap #1: nothing restarted

The first deploy worked. The second one… did nothing. The new image was on ghcr.io, Portainer said the stack was
updated, and the old site was still online.

The reason: the manifest always says `image: ghcr.io/xalri/portfolio:main`. From Kubernetes' point of view, the
Deployment did not change at all, so there was nothing to roll out. `imagePullPolicy: Always` only matters when a
pod *starts*; it does not restart running ones.

The fix is [Keel](https://keel.sh), a small controller that restarts a Deployment when its image is pushed again.
Two annotations on the Deployment:

```yaml
annotations:
  keel.sh/policy: force
  keel.sh/match-tag: "true"
```

And one last step in the workflow tells Keel the image was pushed:

```bash
curl -fsS -X POST "$KEEL" -H "Content-Type: application/json" \
  -d '{"name": "ghcr.io/xalri/portfolio", "tag": "main"}'
```

> Lesson: with a moving tag like `main` or `latest`, *something* has to trigger the restart. Kubernetes will not
> do it alone.

## Trap #2: a 403 on every project page

Once in the container, every `/project?project=…` page answered **403 Forbidden**, while it worked fine before.

The site had an old `project/` folder in `public/`. Apache saw the URL `/project`, found a folder with that name,
and tried to list it, which `Options -Indexes` forbids. My rewrite rule that adds `.php` was never reached, because
it skips anything that exists on disk:

```apache
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME}.php -f
RewriteRule ^(.*[^/])/?$ $1.php [NC,L]
```

The fix: remove the folder and redirect its old URLs to the new page with a `301`, so old links still work.

## What I would do next

- [x] Deploy on every push
- [x] Keep one image per commit to roll back
- [ ] Add a real health check instead of a TCP probe
- [ ] Run PHP's syntax check in the workflow before building

The whole setup is in the [repository](https://github.com/Xalri/portfolio) if you want to copy it.
