#!/bin/sh
set -e

# first arg is `-f` or `--some-option`
if [ "${1#-}" != "$1" ]; then
	set -- php-fpm "$@"
fi

# Determine the IP of host Docker is running on
host_ip_as_seen_from_docker=`/sbin/ip route|awk '/default/ { print $3 }'`

# Finish configuring xDebug - this needs to be dynamic to work on all hosts
echo "xdebug.remote_host=${host_ip_as_seen_from_docker}" >> /usr/local/etc/php/conf.d/php.ini

# Gid 82 is www-data.
chown -R :82 /var/www/html
chmod -R g+s /var/www/html
chown 82:82 /var/log/php-fpm && chmod 0755 /var/log/php-fpm
[ -d /var/www/html/var/cache ] && chmod -R 2777 /var/www/html/var/cache # set permissions only if dir exists

exec "$@"
