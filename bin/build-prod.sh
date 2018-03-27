#!/usr/bin/env bash

bin/build-dev.sh

# Optimize API Dependencies for production
docker-compose run homescreen-api \
  composer install --no-suggest --optimize-autoloader --no-dev --classmap-authoritative

# Build app.js in production mode
docker-compose run homescreen-app \
    node_modules/webpack/bin/webpack.js -p
