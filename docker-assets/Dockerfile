FROM abiosoft/caddy:php

ADD docker-assets/php.ini /etc/php7/php.ini
ADD docker-assets/php-fpm.conf /etc/php7/php-fpm.conf

RUN apk add php7-simplexml
