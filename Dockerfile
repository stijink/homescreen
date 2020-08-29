# Stage: base
FROM php:7.4-apache AS base

    WORKDIR /var/www

    ENV COMPOSER_ALLOW_SUPERUSER=1
    ENV DEBIAN_FRONTEND=noninteractive

    # Apache configuration
    COPY build/apache-conf/000-default.conf /etc/apache2/sites-available/

    # Enable Apache mod_rewrite
    RUN a2enmod rewrite

    # Install PHP Extensions
    RUN docker-php-ext-install opcache pcntl

    # intl extension (required by symfony)
    RUN apt-get update \
    && apt-get install -y zlib1g-dev libicu-dev g++ \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl

    # PHP Configuration
    COPY build/php-conf/*.ini /usr/local/etc/php/conf.d/

# Stage: Development
FROM base as development

    # Install node.js apt repository
    RUN curl -sL https://deb.nodesource.com/setup_12.x | bash -

    # Needed by composer / yarn
    RUN apt-get update && apt-get install -y unzip nodejs

    # Install yarn
    RUN npm install -g yarn

    # Install composer (PHP)
    RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Stage: Proproduction
FROM development as preproduction

    COPY . .

    # Install PHP dependencies
    RUN APP_ENV=prod composer install --no-dev --classmap-authoritative --working-dir=api/

    # Install nodejs dependencies
    RUN yarn --cwd app/ install

    # Build the frontend and copy it to the apache webroot
    RUN yarn --cwd app/ encore production

    # Warmup symfony cache
    RUN APP_ENV=prod api/bin/console --no-debug cache:warmup

    # Load the calendars
    RUN  APP_ENV=prod api/bin/console calendars:load


# Stage: Proproduction
FROM base as production

    # Copy the installed files from preproduction
    COPY --from=preproduction /var/www/api /var/www/api
