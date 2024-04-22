FROM php:8.2.6-apache
RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip

ENV COMPOSER_ALLOW_SUPERUSER=1
ARG COMPOSER_VERSION=2.7.2
RUN curl -sS https://getcomposer.org/installer | php -- \
    --filename=composer \
    --install-dir=/usr/local/bin \
    --version=${COMPOSER_VERSION} \
    && composer clear-cache ;
WORKDIR /var/www/html
# Copy Symfony Console project files
COPY . /var/www/html
COPY /bin/console /var/www/html/bin/console

# Install dependencies
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Expose port and start Apache server
EXPOSE 80