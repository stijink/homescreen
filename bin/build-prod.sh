#!/usr/bin/env bash

bin/build-dev.sh

# Build app.js in production mode
docker-compose run homescreen-app \
    node_modules/webpack/bin/webpack.js -p
