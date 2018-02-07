#!/usr/bin/env bash

docker-compose down --remove-orphans

# Remove unused containers
docker-compose rm --force
