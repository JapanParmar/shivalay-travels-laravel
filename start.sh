#!/usr/bin/env bash

echo "🚀 Starting Laravel on Render..."

# Run migrations
php artisan migrate --force

# Run database seeder (if you have seeders)
php artisan db:seed --force

echo "✅ Migrations and Seeding completed!"

# Start PHP-FPM and Nginx
php-fpm && nginx -g 'daemon off;'