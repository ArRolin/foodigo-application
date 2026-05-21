FROM php:8.2-fpm

ENV DEBIAN_FRONTEND=noninteractive

# Install PHP extensions using pre-compiled binaries (much faster than compiling from source)
COPY --from=mlocati/php-extension-installer:latest /usr/bin/install-php-extensions /usr/local/bin/

RUN install-php-extensions \
    pdo_mysql mbstring exif pcntl bcmath gd zip intl gmp opcache

# Install system dependencies (MariaDB + Redis + Nginx + Supervisor)
RUN apt-get update && apt-get install -y \
    git curl zip unzip nginx supervisor cron \
    mariadb-server redis-server \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Node.js 20
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy composer files first for caching
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist

# Copy package files and install node deps
COPY package.json ./
RUN npm install --no-audit --no-fund

# Copy the rest of the app
COPY . .

# Generate optimized autoloader
RUN composer dump-autoload --optimize

# Build frontend assets
RUN npm run build

# Create required directories
RUN mkdir -p /run/mysqld /var/log/mysql /var/log/nginx \
    && chown mysql:mysql /run/mysqld \
    && chown -R mysql:mysql /var/log/mysql

# Set Laravel permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

# Copy configs
COPY docker/nginx.conf /etc/nginx/sites-available/default
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/mysql.cnf /etc/mysql/conf.d/custom.cnf
COPY docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

EXPOSE 80 3306 6379

ENTRYPOINT ["/entrypoint.sh"]
