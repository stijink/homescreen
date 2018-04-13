#!/usr/bin/env bash

docker-compose run --rm homescreen-api \
    bin/console calendars:load
