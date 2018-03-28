#!/usr/bin/env bash

docker-compose run homescreen-api \
    bin/console calendars:load
