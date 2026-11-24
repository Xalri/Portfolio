# The portfolio: PHP pages served by Apache from public/, with mod_rewrite for the .htaccess clean URLs.
# The PHP version is pinned; Dependabot proposes the new ones.

FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --prefer-dist --no-scripts --no-autoloader
COPY src src
RUN composer dump-autoload --no-dev --classmap-authoritative

FROM php:8.6.0RC7-apache

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN a2enmod rewrite headers expires \
 && sed -ri 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
 && docker-php-ext-install opcache

COPY docker/apache.conf /etc/apache2/conf-enabled/zz-portfolio.conf
COPY docker/php.ini /usr/local/etc/php/conf.d/zz-portfolio.ini

WORKDIR /var/www/html
COPY --from=vendor /app/vendor vendor
COPY bootstrap.php ./
COPY config config
COPY content content
COPY lang lang
COPY src src
COPY templates templates
COPY public public

EXPOSE 80
