#!/usr/bin/env bash

# Copy configuration template if no config is given
if [ ! -f config.php ]; then
    cp config.php.dist config.php
fi

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
