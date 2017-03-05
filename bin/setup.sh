#!/usr/bin/env bash

# Install API Dependencies
composer install

# Install App Dependencies
yarn install

# Build app.js
node_modules/webpack/bin/webpack.js -p
