FROM httpd:2.4.58-alpine

RUN rm -rf /usr/local/apache2/htdocs/
COPY ./app/public /usr/local/apache2/htdocs/
RUN chown -R www-data:www-data /usr/local/apache2/htdocs/ \
    && find /usr/local/apache2/htdocs/ -type d -exec chmod 755 {} \; \
    && find /usr/local/apache2/htdocs/ -type f -exec chmod 644 {} \;

COPY ./*.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/*.sh

ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["httpd-foreground"]
