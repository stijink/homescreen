#!/usr/bin/env bash

# Ensure .env exists
if [ ! -f .env ]; then
    cp .env.dist .env
fi

# Ensure api/config/config.json exists
if [ ! -f api/config/config.json ]; then
    cp api/config/config.dist.json api/config/config.json
fi
