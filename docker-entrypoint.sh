#!/bin/bash
set -e

DB_PATH="${DB_DATABASE:-/app/database/database.sqlite}"
mkdir -p "$(dirname "$DB_PATH")"
touch "$DB_PATH"

# Migrations en arrière-plan pour ne pas bloquer le démarrage du serveur
(sleep 5 && php artisan migrate:fresh --seed --force) &

# Démarrer le serveur immédiatement pour satisfaire Render
php artisan serve --host=0.0.0.0 --port="${PORT:-8000}"
