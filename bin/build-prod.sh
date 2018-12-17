#!/usr/bin/env bash

export APP_ENV=prod

# Make sure config files exists
bin/ensure-configuration.sh

# Pull latest versions of docker dependencies and build them
bin/build-containers.sh

# Install and Optimize API Dependencies for production
docker-compose run --rm homescreen-api \
  composer install --classmap-authoritative --no-dev --no-suggest

# Install App Dependencies
docker-compose run --rm homescreen-app \
  yarn install

# Build app.js in production mode
docker-compose run --rm homescreen-app \
    node_modules/webpack/bin/webpack.js -p

# Prefetch calendar contents
bin/load-calendars.sh
