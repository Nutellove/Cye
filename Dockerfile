FROM alpine:3.13
#FROM trafex/alpine-nginx-php7:1.10.0

USER root

#RUN echo 'http://dl-cdn.alpinelinux.org/alpine/edge/testing' >> /etc/apk/repositories && \
RUN apk --no-cache --update add \
        curl \
#        coreutils \
        nginx \
        supervisor \
        php7 \
#        php7-bcmath \
        php7-dom \
        php7-ctype \
        php7-curl \
        php7-fileinfo \
        php7-fpm \
#        php7-gd \
#        php7-iconv \
        php7-intl \
        php7-json \
        php7-mbstring \
#        php7-mcrypt \
#        php7-mysqlnd \
        php7-opcache \
        php7-openssl \
#        php7-pdo \
#        php7-pdo_mysql \
#        php7-pdo_pgsql \
#        php7-pdo_sqlite \
        php7-phar \
        php7-posix \
#        php7-simplexml \
        php7-session \
#        php7-soap \
        php7-tokenizer \
#        php7-xml \
#        php7-xmlreader \
#        php7-xmlwriter \
        php7-zip \
    && rm -rf /var/cache/apk/*

# Install packages and remove default server definition
#RUN apk --no-cache add php7 php7-fpm php7-opcache php7-mysqli php7-json php7-openssl php7-curl \
#    php7-zlib php7-xml php7-phar php7-intl php7-dom php7-xmlreader php7-ctype php7-session \
#    php7-mbstring php7-gd nginx supervisor curl && \
#    rm /etc/nginx/conf.d/default.conf

#RUN rm /etc/nginx/nginx.conf
#COPY docker/cye.nginx.conf /etc/nginx/nginx.conf

# Install composer from the official image
COPY --from=composer /usr/bin/composer /usr/bin/composer

# Configure nginx
RUN rm /etc/nginx/conf.d/default.conf
COPY docker/nginx.conf /etc/nginx/nginx.conf

# Configure PHP-FPM
COPY docker/fpm-pool.conf /etc/php7/php-fpm.d/www.conf
COPY docker/php.ini /etc/php7/conf.d/custom.ini

# Configure supervisord
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Setup document root
RUN mkdir -p /var/www/html

# Make sure files/folders needed by the processes are accessable when they run under the nobody user
RUN chown -R nobody.nobody /var/www/html && \
  chown -R nobody.nobody /run && \
  chown -R nobody.nobody /var/lib/nginx && \
  chown -R nobody.nobody /var/log/nginx

# Switch to use a non-root user from here on
#USER nobody

# Add application
#WORKDIR /var/www/html
#COPY --chown=nobody src/ /var/www/html/



WORKDIR	/var/www
COPY --chown=nobody . .
RUN rm html -R
RUN cp -R web html

#RUN pwd
#RUN whoami
#RUN ls -la

RUN mkdir -p cache

RUN chown -R nobody:nobody html cache

# Run composer install to install the dependencies, AFTER copying the project
RUN composer install --optimize-autoloader --no-interaction --no-progress

# Go back now & here
USER nobody

# Expose the port nginx is reachable on
EXPOSE 8080

# Let supervisord start nginx & php-fpm
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]

# Configure a healthcheck to validate that everything is up&running
HEALTHCHECK --timeout=10s CMD curl --silent --fail http://127.0.0.1:8080/fpm-ping