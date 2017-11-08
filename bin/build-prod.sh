#!/usr/bin/env bash

# Install API Dependencies
composer install --no-dev --optimize-autoloader --no-suggest

# Install App Dependencies
npm install

# Build app.js
node_modules/webpack/bin/webpack.js -p

# Create log directory
mkdir -p -m 777 logs

# Copy configuration template if no config is given
if [ ! -f config.php ]; then
    cp config.php.dist config.php
fi