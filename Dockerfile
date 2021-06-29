FROM trafex/alpine-nginx-php7:1.10.0

USER root

#RUN echo 'http://dl-cdn.alpinelinux.org/alpine/edge/testing' >> /etc/apk/repositories && \
RUN apk --no-cache --update add \
#        curl \
#        coreutils \
#        supervisor \
#        php7 \
#        php7-bcmath \
#        php7-dom \
#        php7-ctype \
#        php7-curl \
#        php7-fileinfo \
#        php7-fpm \
#        php7-gd \
#        php7-iconv \
#        php7-intl \
#        php7-json \
#        php7-mbstring \
#        php7-mcrypt \
#        php7-mysqlnd \
#        php7-opcache \
#        php7-openssl \
#        php7-pdo \
#        php7-pdo_mysql \
#        php7-pdo_pgsql \
#        php7-pdo_sqlite \
#        php7-phar \
#        php7-posix \
#        php7-simplexml \
#        php7-session \
#        php7-soap \
        php7-tokenizer \
#        php7-xml \
#        php7-xmlreader \
#        php7-xmlwriter \
#        php7-zip \
    && rm -rf /var/cache/apk/*

# Install composer from the official image
COPY --from=composer /usr/bin/composer /usr/bin/composer

#RUN rm /etc/nginx/nginx.conf
#COPY docker/cye.nginx.conf /etc/nginx/nginx.conf

WORKDIR	/var/www
COPY . .
RUN rm html -R
RUN cp -R web html

#RUN pwd
#RUN whoami
#RUN ls -la

RUN chown -R nobody:nobody cache

# Run composer install to install the dependencies, AFTER copying the project
RUN composer install --optimize-autoloader --no-interaction --no-progress

USER nobody

