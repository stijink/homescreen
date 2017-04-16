#!/usr/bin/env bash

# Ensure the service is not already running
docker-compose down

# Ensure image is built
docker-compose build

# Start Webserver (Port 8000)
docker-compose up -d

 # Run webpack watch
docker-compose run homescreen-dev node_modules/webpack/bin/webpack.js --watch
