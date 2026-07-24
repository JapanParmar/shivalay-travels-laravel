#!/usr/bin/env bash

echo "🚀 Starting Laravel on Render..."

# Run migrations + seeding
php artisan migrate --force
php artisan db:seed --force

echo "✅ Migrations and Seeding completed!"

# Start supervisor (recommended for this image)
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf