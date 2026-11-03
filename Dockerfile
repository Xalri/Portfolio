# The portfolio: plain PHP pages served by Apache, with mod_rewrite for the .htaccess clean URLs
FROM php:8.4-apache

RUN a2enmod rewrite \
 && sed -ri 's/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf \
 && printf 'session.upload_progress.enabled = 0\nexpose_php = Off\n' > /usr/local/etc/php/conf.d/zz-hardening.ini

WORKDIR /var/www/html
COPY --chown=www-data:www-data . .

EXPOSE 80
