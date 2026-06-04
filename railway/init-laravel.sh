#!/bin/bash
# Make sure this file has executable permissions, run `chmod +x railway/init-app.sh`

# Exit the script if any command fails
set -e

# Run migrations
php artisan migrate:fresh --seed --force
php artisan storage:link

php artisan serve --host=0.0.0.0 --port=$PORT
