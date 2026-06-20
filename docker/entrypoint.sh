#!/bin/bash
set -e

# Railway (y otras plataformas) inyectan el puerto en $PORT.
# En local cae a 80 (sin cambios).
: "${PORT:=80}"

sed -i "s/^Listen 80$/Listen ${PORT}/" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-available/000-default.conf

# Enlace de almacenamiento para imágenes (si no existe)
php artisan storage:link 2>/dev/null || true

# Arranca Apache en primer plano
exec apache2-foreground