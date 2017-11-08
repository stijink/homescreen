#!/usr/bin/env bash

# Ensure the service is not already running
docker-compose down

# Ensure image is built
docker-compose build

# Start services
docker-compose up -d
