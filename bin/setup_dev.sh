#!/usr/bin/env bash

# Ensure image is built
docker-compose build

# Install API Dependencies
docker-compose run homescreen-dev \
  composer install --no-suggest

# Install App Dependencies
docker-compose run homescreen-dev \
  yarn install

# Build app.js
docker-compose run homescreen-dev \
  node_modules/webpack/bin/webpack.js

# Create log directory
docker-compose run homescreen-dev \
  mkdir -p -m 777 logs

# Create html symlink for apache
docker-compose run homescreen-dev \
  ln -s web html
