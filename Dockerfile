FROM php:7.1-apache

# Configure cache for composer and yarn
ENV YARN_CACHE='/var/cache/yarn'
ENV COMPOSER_CACHE_DIR='/var/cache/composer'

# Add composer and yarn to the path
ENV PATH /root/.composer/vendor/bin:$PATH
ENV PATH=/root/.yarn/bin:$PATH

ENV COMPOSER_ALLOW_SUPERUSER=1

# Add nodejs to our package manager sources
RUN curl -sL https://deb.nodesource.com/setup_6.x | bash -

# System Essensials
RUN apt-get install -y \
  zip \
  unzip \
  curl \
  git \
  nodejs

# Common PHP Extensions
RUN docker-php-ext-install opcache

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install yarn
RUN curl -o- -L https://yarnpkg.com/install.sh | bash
