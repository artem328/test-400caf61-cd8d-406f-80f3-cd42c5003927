#!/usr/bin/env sh

echo "upstream php-upstream { server ${UPSTREAM}; }" > ./conf.d/upstream.conf

nginx -g "daemon off;"