#!/bin/sh

# Replace env vars in nginx.conf
envsubst '$PORT' < /etc/nginx/nginx.tpl.conf > /etc/nginx/nginx.conf


# Start services
php-fpm -D
nginx -g "daemon off;"
