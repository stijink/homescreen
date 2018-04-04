#!/usr/bin/env bash

export APP_ENV=dev

# Make sure config files exists
bin/ensure-configuration.sh

# Pull latest versions of our docker images
docker pull stijink/homescreen-api
docker pull stijink/homescreen-app

# Install API Dependencies
docker-compose run homescreen-api \
  composer install --no-suggest

# Install App Dependencies
docker-compose run homescreen-app \
  yarn install
