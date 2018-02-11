#!/usr/bin/env bash

# Ensure .env exists
if [ ! -f .env ]; then
    cp .env.dist .env
fi

# Ensure API var/ directory exists
mkdir -p api/var/

# Pull latest versions of docker dependencies
docker pull php:7.2-apache
docker pull node:9

# Ensure images are built
docker-compose build

# Install API Dependencies
docker-compose run homescreen-api \
  composer install --no-suggest

# Install App Dependencies
docker-compose run homescreen-app \
  yarn install
