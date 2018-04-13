#!/usr/bin/env bash

docker-compose run --rm homescreen-api vendor/bin/phpunit --debug $1
