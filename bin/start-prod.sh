#!/usr/bin/env bash

# Start the stack
bin/start-dev.sh

# We don't need the app container in production
# This could be solved more elegantly.
# But this will work for now.
docker-compose stop homescreen-app
