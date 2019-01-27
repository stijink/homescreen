#!/usr/bin/env bash

docker-compose run --rm homescreen-api \
    vendor/bin/php-cs-fixer fix --verbose
