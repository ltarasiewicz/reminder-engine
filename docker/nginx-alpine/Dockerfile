FROM nginx:1.11-alpine

RUN ["mkdir", "/etc/nginx/sites-enabled"]
RUN ["mkdir", "-p", "/var/www/html"]

COPY ./config/nginx.conf /etc/nginx/nginx.conf
COPY config/sites-enabled /etc/nginx/sites-enabled/
COPY config/fastcgi_params.conf /etc/nginx/

#RUN addgroup -g 82 www-data

#RUN addgroup sudo
#RUN adduser -D luqo33 -G sudo
#RUN echo '%sudo ALL=(ALL) NOPASSWD:ALL' >> /etc/sudoers

# Make sure user and group www-data exist with uid and gid 82
RUN set -x ; \
getent group www-data || addgroup -g 82 -S www-data ; \
  id -u www-data || adduser -u 82 -D -S -G www-data www-data
