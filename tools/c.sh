#!/bin/bash

echo "Run 'composer #' in the php-fpm container";
docker exec -u $(id -u $USER)  php-reminder-engine sh -c "composer $*"
