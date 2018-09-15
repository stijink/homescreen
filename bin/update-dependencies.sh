#!/usr/bin/env bash

docker-compose run --rm homescreen-api composer update --with-dependencies
docker-compose run --rm homescreen-app yarn upgrade
