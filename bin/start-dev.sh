#!/usr/bin/env bash

# Make sure the containers are not already running
bin/stop.sh

# Ensure the service is not already running
docker-compose down

# Start services
docker-compose up -d --remove-orphans
