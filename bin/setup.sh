#!/usr/bin/env bash

# Install API Dependencies
composer install

# Install App Dependencies
yarn install

# Build app.js
webpack -p
