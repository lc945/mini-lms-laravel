#!/bin/bash
set -e

DB_PATH="${DB_DATABASE:-/app/database/database.sqlite}"
mkdir -p "$(dirname "$DB_PATH")"
touch "$DB_PATH"

php artisan migrate:fresh --seed --force
php artisan serve --host=0.0.0.0 --port="${PORT:-8000}"
