FROM php:8.0-fpm as scratch

ARG APP_ENV
ENV APP_ENV=${APP_ENV}

# Add php config
COPY .docker/php-fpm/php_${APP_ENV}.ini /usr/local/etc/php/php.ini
COPY .docker/php-fpm/www.conf /usr/local/etc/php-fpm.d/www.conf

RUN apt-get update && apt-get install -y git git-core zip wget unzip vim gnupg curl zlibc \
    libonig-dev \
    libzip-dev \
    zlib1g-dev \
    libpq-dev \
    libmcrypt-dev \
    libfcgi0ldbl \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libicu-dev \
    libz-dev \
    && docker-php-ext-install pdo pdo_mysql mysqli intl pcntl mbstring bcmath gd zip \
    && docker-php-ext-enable mysqli

    # MAKE tmp WRITABLE
RUN chmod 777 -R /tmp && chmod o+t -R /tmp \
    && wget https://getcomposer.org/installer -O - -q | php -- --install-dir=/bin --filename=composer --quiet \
    && echo 'alias bc="php bin/console"' >> ~/.bashrc

ENV TZ=Europe/Kiev
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

ENV COMPOSER_ALLOW_SUPERUSER 1

WORKDIR /var/www/html

# DEV env (local)
FROM scratch as dev

RUN curl -sS https://get.symfony.com/cli/installer | bash \
    && mv /root/.symfony/bin/symfony /usr/local/bin/symfony \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug

# PROD env (kubernetes)
FROM scratch as prod

#RUN /usr/bin/composer install --no-ansi --no-dev -n --no-plugins --no-progress --no-scripts --no-suggest -o \
#    && chown -R www-data:www-data .

USER www-data:www-data
CMD ["php-fpm"]
EXPOSE 9000