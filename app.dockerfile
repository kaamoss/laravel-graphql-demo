FROM php:7.4-fpm

RUN apt-get update && apt-get install -y libmcrypt-dev \
    mariadb-client unzip libmagickwand-dev wget --no-install-recommends \
    && pecl install imagick \
    && docker-php-ext-enable imagick \
    && pecl install xdebug && docker-php-ext-enable xdebug \
    && docker-php-ext-install pdo_mysql

# Install APCu and APC backward compatibility
RUN pecl install apcu \
    && pecl install apcu_bc-1.0.3 \
    && docker-php-ext-enable apcu --ini-name 10-docker-php-ext-apcu.ini \
    && docker-php-ext-enable apc --ini-name 20-docker-php-ext-apc.ini

#install composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer

#install phing
RUN wget https://www.phing.info/get/phing-2.16.1.phar
RUN cp phing-2.16.1.phar /usr/local/bin/phing && chmod +x /usr/local/bin/phing

#install phpdoc
RUN wget https://www.phpdoc.org/phpDocumentor.phar
RUN cp phpDocumentor.phar /usr/local/bin/phpdoc && chmod +x /usr/local/bin/phpdoc

#install phpunit
RUN wget -O phpunit https://phar.phpunit.de/phpunit-8.phar
RUN cp phpunit /usr/local/bin/phpunit && chmod +x /usr/local/bin/phpunit

#install cachetool
RUN wget -O cachetool http://gordalina.github.io/cachetool/downloads/cachetool.phar
RUN cp cachetool /usr/local/bin/cachetool && chmod +x /usr/local/bin/cachetool

#xdebug goodness
RUN echo "xdebug.idekey = PHPSTORMAPI" >>  /usr/local/etc/php/conf.d/20-xdebug.ini
RUN echo "xdebug.default_enable = 0" >>  /usr/local/etc/php/conf.d/20-xdebug.ini
RUN echo "xdebug.remote_enable = 1" >>  /usr/local/etc/php/conf.d/20-xdebug.ini
RUN echo "xdebug.remote_autostart = 1" >>  /usr/local/etc/php/conf.d/20-xdebug.ini
RUN echo "xdebug.remote_connect_back = off" >>  /usr/local/etc/php/conf.d/20-xdebug.ini
RUN echo "xdebug.profiler_enable = 0" >> /usr/local/etc/php/conf.d/20-xdebug.ini
RUN echo "xdebug.remote_host = 10.254.254.254" >>  /usr/local/etc/php/conf.d/20-xdebug.ini
RUN echo "xdebug.remote_port=9006" >>  /usr/local/etc/php/conf.d/20-xdebug.ini
