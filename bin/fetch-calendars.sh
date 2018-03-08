#!/usr/bin/env bash

docker-compose run homescreen-api \
    bin/console calendars:cache

docker-compose run homescreen-api \
    bin/console calendars:shrink
