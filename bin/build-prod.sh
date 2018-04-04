#!/usr/bin/env bash

export APP_ENV=prod

# Make sure config files exists
bin/ensure-configuration.sh

# Pull latest versions of our docker images
docker pull stijink/homescreen-api
docker pull stijink/homescreen-app

# Install and Optimize API Dependencies for production
docker-compose run homescreen-api \
  composer install --classmap-authoritative --no-dev --no-suggest

# Install App Dependencies
docker-compose run homescreen-app \
  yarn install

# Build app.js in production mode
docker-compose run homescreen-app \
    node_modules/webpack/bin/webpack.js -p
