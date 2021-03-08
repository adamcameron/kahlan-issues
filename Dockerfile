FROM php:8.0.3-cli
RUN apt-get update
RUN apt-get install git zip unzip --yes
COPY ./src /usr/share/kahlan-issues/src
COPY ./spec /usr/share/kahlan-issues/spec
COPY ./composer.json /usr/share/kahlan-issues/composer.json
COPY --from=composer /usr/bin/composer /usr/bin/composer
WORKDIR  /usr/share/kahlan-issues/
RUN composer install
