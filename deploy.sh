#!/usr/bin/env bash

set -Eeuo pipefail

APP_CONTAINER="laravel-app"
DB_CONTAINER="laravel-db"
MAX_RETRIES=45
SLEEP_SECONDS=2

run_compose() {
  if command -v docker >/dev/null 2>&1; then
    if docker compose version >/dev/null 2>&1; then
      docker compose "$@"
      return
    fi
  fi

  if command -v sudo >/dev/null 2>&1 && sudo -n docker compose version >/dev/null 2>&1; then
    sudo docker compose "$@"
    return
  fi

  echo "❌ No se pudo ejecutar 'docker compose'. Verifica Docker o permisos de sudo."
  exit 1
}

run_exec() {
  local container="$1"
  shift

  if docker exec "$container" "$@" >/dev/null 2>&1; then
    docker exec "$container" "$@"
    return
  fi

  if command -v sudo >/dev/null 2>&1; then
    sudo docker exec "$container" "$@"
    return
  fi

  echo "❌ No se pudo ejecutar comando en el contenedor '$container'."
  exit 1
}

echo "🚀 Iniciando despliegue de Laravel 12..."

# 1) Levantar contenedores
run_compose up -d

# 2) Esperar a PostgreSQL
printf "⏳ Esperando a PostgreSQL"
for i in $(seq 1 "$MAX_RETRIES"); do
  if run_exec "$DB_CONTAINER" pg_isready -U laravel_user >/dev/null 2>&1; then
    echo " ✅"
    break
  fi

  if [ "$i" -eq "$MAX_RETRIES" ]; then
    echo
    echo "❌ PostgreSQL no estuvo listo a tiempo."
    exit 1
  fi

  printf "."
  sleep "$SLEEP_SECONDS"
done

# 3) Permisos de escritura para Laravel
run_exec "$APP_CONTAINER" sh -lc "chmod -R ug+rwX storage bootstrap/cache"

# 4) Migraciones
echo "🗄️ Ejecutando migraciones..."
run_exec "$APP_CONTAINER" php artisan migrate --force

# 5) Enlace público a storage (idempotente)
echo "🔗 Verificando enlace storage..."
run_exec "$APP_CONTAINER" sh -lc "if [ -L public/storage ]; then echo '✅ public/storage ya es symlink'; elif [ -d public/storage ]; then backup='public/storage_dir_backup_'\$(date +%Y%m%d_%H%M%S); mv public/storage \"\$backup\"; echo \"⚠️ public/storage era carpeta. Backup: \$backup\"; php artisan storage:link; else php artisan storage:link; fi"

# 6) Limpiar y reconstruir cachés
echo "⚙️ Limpiando y regenerando cachés..."
run_exec "$APP_CONTAINER" php artisan optimize:clear
run_exec "$APP_CONTAINER" php artisan config:cache
run_exec "$APP_CONTAINER" php artisan route:cache
run_exec "$APP_CONTAINER" php artisan view:cache

echo "✅ Despliegue completado correctamente."
