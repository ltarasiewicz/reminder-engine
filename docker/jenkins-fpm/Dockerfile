FROM jenkins:2.32.2-alpine

USER root
RUN apk --update add php5 php5-json php5-phar php5-openssl php5-zlib

USER jenkins
RUN mkdir ~/bin && cd ~/bin \
    && curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar composer

COPY executors.groovy /usr/share/jenkins/ref/init.groovy.d/executors.groovy
