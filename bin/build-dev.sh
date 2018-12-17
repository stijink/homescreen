#!/usr/bin/env bash

export APP_ENV=dev

# Make sure config files exists
bin/ensure-configuration.sh

# Pull latest versions of docker dependencies and build them
bin/build-containers.sh

# Install API Dependencies
docker-compose run --rm homescreen-api \
  composer install --no-suggest

# Install App Dependencies
docker-compose run --rm homescreen-app \
  yarn install
