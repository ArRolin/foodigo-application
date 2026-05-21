#!/bin/bash
set -e

ENV_FILE="/var/www/html/.env"

# Generate APP_KEY if not provided
if [ -z "$APP_KEY" ]; then
    echo "Generating APP_KEY..."
    php artisan key:generate --force
    APP_KEY=$(grep '^APP_KEY=' "$ENV_FILE" | cut -d'=' -f2-)
    export APP_KEY
else
    if [ -f "$ENV_FILE" ]; then
        if grep -q '^APP_KEY=' "$ENV_FILE"; then
            sed -i "s|^APP_KEY=.*|APP_KEY=$APP_KEY|" "$ENV_FILE"
        else
            echo "APP_KEY=$APP_KEY" >> "$ENV_FILE"
        fi
    fi
fi

# Generate JWT_SECRET if not set
if [ -z "$JWT_SECRET" ]; then
    JWT_SECRET=$(openssl rand -base64 32 | tr -dc 'a-zA-Z0-9' | head -c 32)
    echo "Generated JWT_SECRET"
    if [ -f "$ENV_FILE" ]; then
        if grep -q '^JWT_SECRET=' "$ENV_FILE"; then
            sed -i "s/^JWT_SECRET=.*/JWT_SECRET=$JWT_SECRET/" "$ENV_FILE"
        else
            echo "JWT_SECRET=$JWT_SECRET" >> "$ENV_FILE"
        fi
    fi
    export JWT_SECRET
fi

# Run migrations if AUTO_MIGRATE is set
if [ "$AUTO_MIGRATE" = "true" ]; then
    echo "Running migrations..."
    php artisan migrate --force || echo "WARNING: Migrations had errors (tables may already exist)"
fi

# Clear and cache config
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

echo "=== Foodigo Ready ==="
echo "APP_URL: ${APP_URL:-http://localhost}"
echo "DB: ${DB_HOST:-external}:${DB_PORT:-3306}/${DB_DATABASE:-foodigo}"

exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
