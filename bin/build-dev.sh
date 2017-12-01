#!/usr/bin/env bash

# Copy configuration template if no config is given
if [ ! -f api/config.php ]; then
    cp api/config.php.dist api/config.php
fi

# Pull latest versions of docker dependencies
docker pull php:7.1-apache
docker pull node:8

# Ensure images are built
docker-compose build

# Install API Dependencies
docker-compose run homescreen-api \
  composer install --no-suggest

# Install App Dependencies
docker-compose run homescreen-app \
  yarn install

# Create logs directory
docker-compose run homescreen-api \
  mkdir -p -m 777 logs
