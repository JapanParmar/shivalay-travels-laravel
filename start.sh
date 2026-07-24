#!/usr/bin/env bash

echo "🚀 Starting Laravel on Render..."

# Storage link for public assets
php artisan storage:link || true

# Run migrations + seeding
php artisan migrate --force
php artisan db:seed --force

echo "✅ Migrations and Seeding completed!"

# Start server
exec php artisan serve --host=0.0.0.0 --port=${PORT:-10000}