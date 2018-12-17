#!/usr/bin/env bash

# Pull latest versions of docker dependencies
docker pull php:7.3-apache
docker pull node:9

# Ensure images are built
docker-compose build
