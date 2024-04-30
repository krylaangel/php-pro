FROM php:8.2.6-apache
RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip

# Installs PHP extensions
RUN docker-php-ext-install \
    pdo_mysql \
    opcache

ENV COMPOSER_ALLOW_SUPERUSER=1
ARG COMPOSER_VERSION=2.7.2
RUN curl -sS https://getcomposer.org/installer | php -- \
    --filename=composer \
    --install-dir=/usr/local/bin \
    --version=${COMPOSER_VERSION} \
    && composer clear-cache ; \

# Install dependencies
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Expose port and start Apache server
EXPOSE 80
#xdebug
ARG XDEBUG_ENABLED=false
RUN if $XDEBUG_ENABLED; then pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.max_nesting_level=1000" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    ; fi

WORKDIR /var/www/html
# Copy Symfony Console project files
COPY . /var/www/html
COPY /bin/console /var/www/html/bin/console
