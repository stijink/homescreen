#!/usr/bin/env bash

# Install API Dependencies
composer install --no-suggest

# Install App Dependencies
yarn install

# Build app.js
node_modules/webpack/bin/webpack.js

# Create log directory
mkdir -p -m 777 logs
