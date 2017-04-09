#!/usr/bin/env bash

# Install API Dependencies
composer install --no-dev --optimize-autoloader

# Install App Dependencies
yarn install

# Build app.js
node_modules/webpack/bin/webpack.js -p

# Create log directory
mkdir -p -m 777 logs
