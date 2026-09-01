#!/bin/sh
set -e

php artisan migrate:fresh --seed --force
php artisan storage:link || true

exec supervisord -c /etc/supervisor/conf.d/supervisord.conf
