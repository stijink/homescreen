#!/usr/bin/env bash

# Ensure .env exists
if [ ! -f .env ]; then
    cp .env.dist .env
fi

# Pull latest versions of docker dependencies
docker pull php:7.2-apache
docker pull node:9

# Ensure images are built
docker-compose build

# Ensure API var/ directory exists
  docker-compose run homescreen-api \
    mkdir -p var/

# Install API Dependencies
docker-compose run homescreen-api \
  composer install --no-suggest

# Install App Dependencies
docker-compose run homescreen-app \
  yarn install
