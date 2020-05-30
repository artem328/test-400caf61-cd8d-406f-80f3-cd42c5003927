#!/usr/bin/env sh

COMMAND="composer install --prefer-dist --no-progress --no-suggest --no-interaction"

if [[ "prod" = "${APP_ENV}" ]]; then
    COMMAND="${COMMAND} --no-dev  --optimize-autoloader --classmap-authoritative"
fi

su \
    -c "${COMMAND}" \
    -s /bin/sh \
    -m \
    www-data

chown -R www-data: var/

php-fpm