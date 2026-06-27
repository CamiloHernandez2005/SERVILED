#!/bin/bash
set -e

# Railway (y otras plataformas) inyectan el puerto en $PORT.
# En local cae a 8080.
: "${PORT:=8080}"

# Borra manifiestos de paquetes cacheados: pueden venir del entorno de
# desarrollo (montado por volumen) y referenciar paquetes de dev que la
# imagen no instaló (--no-dev). Laravel los regenera limpios al arrancar.
rm -f bootstrap/cache/packages.php bootstrap/cache/services.php bootstrap/cache/*.tmp 2>/dev/null || true

# --- Esperar a que la base de datos esté lista (hasta ~60s) ---
echo "Esperando la base de datos..."
tries=0
until php -r '
    $h = getenv("DB_HOST") ?: "127.0.0.1";
    $p = getenv("DB_PORT") ?: "3306";
    $u = getenv("DB_USERNAME") ?: "root";
    $pw = getenv("DB_PASSWORD") ?: "";
    try { new PDO("mysql:host=$h;port=$p", $u, $pw); exit(0); }
    catch (Exception $e) { exit(1); }
' 2>/dev/null
do
    tries=$((tries + 1))
    if [ "$tries" -ge 30 ]; then
        echo "La base de datos no respondió a tiempo; continuando de todos modos."
        break
    fi
    sleep 2
done

# Enlace de almacenamiento para imágenes (si no existe; ignora si ya está)
php artisan storage:link >/dev/null 2>&1 || true

# Limpia config cacheada por si quedó de un build anterior
php artisan config:clear >/dev/null 2>&1 || true

# Ejecutar migraciones pendientes
php artisan migrate --force || true

# Sembrar datos iniciales SOLO la primera vez (cuando aún no hay roles)
NEEDS_SEED=$(php -r '
    require "vendor/autoload.php";
    $app = require "bootstrap/app.php";
    $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
    try { echo \Illuminate\Support\Facades\DB::table("roles")->count(); }
    catch (\Throwable $e) { echo "1"; }
' 2>/dev/null)

if [ "$NEEDS_SEED" = "0" ]; then
    echo "Sembrando datos iniciales (roles, unidades, municipios)..."
    php artisan db:seed --force || true
fi

# Arranca el servidor de PHP sirviendo /public
exec php artisan serve --host=0.0.0.0 --port="${PORT}"
