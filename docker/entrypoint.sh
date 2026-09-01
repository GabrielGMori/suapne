#!/bin/sh
set -e

php artisan migrate --force
php artisan storage:link || true

exec supervisord -c /etc/supervisor/conf.d/supervisord.conf
