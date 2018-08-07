#!/usr/bin/env bash

docker-compose run --rm -e APP_ENV=test homescreen-api vendor/bin/phpunit --debug $1
