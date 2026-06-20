#!/bin/bash
set -e

# Railway (y otras plataformas) inyectan el puerto en $PORT.
# En local cae a 8080.
: "${PORT:=8080}"

# Enlace de almacenamiento para imágenes (si no existe; ignora si ya está)
php artisan storage:link >/dev/null 2>&1 || true

# Limpia config cacheada por si quedó de un build anterior
php artisan config:clear >/dev/null 2>&1 || true

# Arranca el servidor de PHP sirviendo /public
exec php artisan serve --host=0.0.0.0 --port="${PORT}"