#!/bin/bash
set -e

ENV_FILE="/var/www/html/.env"

# Generate DB_PASSWORD if not provided
if [ -z "$DB_PASSWORD" ]; then
    DB_PASSWORD=$(openssl rand -base64 24 | tr -dc 'a-zA-Z0-9' | head -c 32)
    echo "Generated DB_PASSWORD: $DB_PASSWORD"
    if [ -f "$ENV_FILE" ]; then
        sed -i "s/^DB_PASSWORD=.*/DB_PASSWORD=$DB_PASSWORD/" "$ENV_FILE"
    fi
    export DB_PASSWORD
fi

# Generate APP_KEY if not provided
if [ -z "$APP_KEY" ]; then
    echo "Generating APP_KEY..."
    php artisan key:generate --force
    APP_KEY=$(grep '^APP_KEY=' "$ENV_FILE" | cut -d'=' -f2-)
    export APP_KEY
else
    # Ensure APP_KEY is in .env
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

# Initialize MySQL data directory if needed
if [ ! -d "/var/lib/mysql/mysql" ]; then
    echo "Initializing MySQL data directory..."
    mysqld --initialize-insecure --user=mysql
fi

# Ensure correct permissions
chown -R mysql:mysql /var/lib/mysql /run/mysqld

# Start MySQL temporarily to create database and user
echo "Starting MySQL for setup..."
mysqld --user=mysql &
sleep 5

# Wait for MySQL to be ready
for i in $(seq 1 30); do
    if mysqladmin ping -h localhost --silent 2>/dev/null; then
        break
    fi
    echo "Waiting for MySQL... ($i)"
    sleep 1
done

# Create database and user
DB_NAME=${DB_DATABASE:-foodigo}
DB_USER=${DB_USERNAME:-foodigo}

echo "Setting up database: $DB_NAME"
mysql -u root <<EOF
CREATE DATABASE IF NOT EXISTS \`$DB_NAME\` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER IF NOT EXISTS '$DB_USER'@'localhost' IDENTIFIED BY '$DB_PASSWORD';
CREATE USER IF NOT EXISTS '$DB_USER'@'127.0.0.1' IDENTIFIED BY '$DB_PASSWORD';
CREATE USER IF NOT EXISTS '$DB_USER'@'%' IDENTIFIED BY '$DB_PASSWORD';
GRANT ALL PRIVILEGES ON \`$DB_NAME\`.* TO '$DB_USER'@'localhost';
GRANT ALL PRIVILEGES ON \`$DB_NAME\`.* TO '$DB_USER'@'127.0.0.1';
GRANT ALL PRIVILEGES ON \`$DB_NAME\`.* TO '$DB_USER'@'%';
FLUSH PRIVILEGES;
EOF

# Stop temporary MySQL
mysqladmin -u root shutdown
sleep 2

# Run migrations if AUTO_MIGRATE is set
if [ "$AUTO_MIGRATE" = "true" ]; then
    echo "Running migrations..."
    php artisan migrate --force
fi

echo "=== Foodigo Ready ==="
echo "APP_URL: ${APP_URL:-http://localhost}"
echo "DB: $DB_NAME @ 127.0.0.1:3306"

exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
