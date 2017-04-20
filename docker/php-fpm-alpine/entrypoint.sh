#!/bin/sh
set -e

# first arg is `-f` or `--some-option`
if [ "${1#-}" != "$1" ]; then
	set -- php-fpm "$@"
fi

# Determine the IP of host Docker is running on
host_ip_as_seen_from_docker=`/sbin/ip route|awk '/default/ { print $3 }'`

# Finish configuring xDebug - this needs to be dynamic to work on all hosts
RUN echo "xdebug.remote_host=${host_ip_as_seen_from_docker}" >> /usr/local/etc/php/conf.d/php.ini

exec "$@"
