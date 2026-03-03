#!/bin/bash

echo "🚀 Iniciando despliegue de Laravel 12..."

# 1. Levantar contenedores (lee todo del docker-compose)
sudo docker compose up -d

# 2. Esperar a Postgres (clave para que la migración no falle)
echo "Esperando a PostgreSQL..."
until sudo docker exec laravel-db pg_isready -U laravel_user; do
  sleep 2
done

# 3. Permisos (FrankenPHP en Alpine usa ID 1000 por defecto)
sudo chmod -R 775 storage bootstrap/cache

# 4. Migraciones
echo "Ejecutando migraciones..."
sudo docker exec laravel-app php artisan migrate --force

# 5. Optimización de caché (Crítico para que Laravel vaya rápido)
sudo docker exec laravel-app php artisan config:cache
sudo docker exec laravel-app php artisan route:cache

echo "✅ ¡Todo listo en http://tu-dominio.somosdelprieto.com!"