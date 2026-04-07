#!/bin/bash
set -e

# Mettre à jour le port Apache selon la variable PORT de Render
PORT=${PORT:-80}
sed -i "s/Listen 80/Listen $PORT/" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:80>/<VirtualHost *:$PORT>/" /etc/apache2/sites-available/000-default.conf

# Migrations et seed
php artisan migrate:fresh --seed --force

# Démarrer Apache
apache2-foreground
