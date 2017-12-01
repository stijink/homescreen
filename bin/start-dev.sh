#!/usr/bin/env bash

# Make sure the containers are not already running
bin/stop-dev.sh

# Ensure the service is not already running
docker-compose down

# Ensure image is built
docker-compose build

# Start services
docker-compose up -d
