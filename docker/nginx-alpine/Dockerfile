FROM nginx:1.11-alpine

RUN ["mkdir", "/etc/nginx/sites-enabled"]
RUN ["mkdir", "-p", "/var/www/html"]

COPY ./config/nginx.conf /etc/nginx/nginx.conf
COPY config/sites-enabled /etc/nginx/sites-enabled/
COPY config/fastcgi_params.conf /etc/nginx/

RUN addgroup www-data

RUN addgroup sudo
RUN adduser -D luqo33 -G sudo
RUN echo '%sudo ALL=(ALL) NOPASSWD:ALL' >> /etc/sudoers
