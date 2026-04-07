#!/bin/bash
set -e

PORT=${PORT:-80}
sed -i "s/Listen 80/Listen $PORT/" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:80>/<VirtualHost *:$PORT>/" /etc/apache2/sites-available/000-default.conf

# Créer le fichier SQLite peu importe le chemin configuré
DB_PATH="${DB_DATABASE:-/var/www/html/database/database.sqlite}"
mkdir -p "$(dirname "$DB_PATH")"
touch "$DB_PATH"
chown www-data:www-data "$DB_PATH"

php artisan migrate:fresh --seed --force

apache2-foreground
