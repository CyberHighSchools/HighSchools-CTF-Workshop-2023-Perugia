FROM httpd:2.4.58-alpine

RUN apk update \
    && apk add --no-cache \
        php82-apache2 \
        php82-mysqli \
        php82-session \
        php82-cli \
        netcat-openbsd \
    && rm -rf /var/cache/apk/* \
    && rm -rf /usr/local/apache2/htdocs/ \
    && cp -a /etc/apache2/conf.d/php82-module.conf /usr/local/apache2/conf/extra/ \
    && cp -a /usr/lib/apache2/mod_php82.so /usr/local/apache2/modules/
COPY ./httpd.conf /usr/local/apache2/conf/httpd.conf

COPY ./app/ /usr/local/apache2/htdocs/
RUN chown -R www-data:www-data /usr/local/apache2/htdocs/ \
    && find /usr/local/apache2/htdocs/ -type d -exec chmod 755 {} \; \
    && find /usr/local/apache2/htdocs/ -type f -exec chmod 644 {} \;

COPY ./*.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/*.sh

ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["httpd-foreground"]
