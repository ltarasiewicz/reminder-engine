#!/usr/bin/env bash

docker exec $(docker ps | grep php71 | cut -f1 -d' ') ./vendor/bin/behat
