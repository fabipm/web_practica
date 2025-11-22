# Multi-stage Dockerfile for Laravel + Vite assets
# Stage 1: Composer dependencies
FROM composer:2.7 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader --no-scripts --no-progress

# Stage 2: Node build for frontend assets
FROM node:20-bullseye AS node-builder
WORKDIR /app
COPY package.json package-lock.json ./
# Install dependencies - npm ci for production builds
RUN npm ci --prefer-offline --no-audit --progress=false
COPY resources ./resources
COPY vite.config.js .
# Create public directory for build output
RUN mkdir -p public
RUN npm run build

# Final stage: PHP-FPM + Nginx + Supervisor
FROM php:8.2-fpm-bullseye

ARG UID=1000
ARG GID=1000

ENV COMPOSER_ALLOW_SUPERUSER=1

WORKDIR /var/www/html

# Install system packages and PHP extensions required
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
       git \
       unzip \
       zip \
       libpng-dev \
       libjpeg-dev \
       libwebp-dev \
       libonig-dev \
       libzip-dev \
       libxml2-dev \
       ca-certificates \
       curl \
       supervisor \
       nginx \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip \
    && rm -rf /var/lib/apt/lists/*

# Configure php-fpm to listen on TCP 9000 (so nginx can connect to 127.0.0.1:9000)
RUN sed -i "s/listen = .*/listen = 9000/" /usr/local/etc/php-fpm.d/www.conf

# Copy application source
COPY . /var/www/html

# Copy vendor from composer stage
COPY --from=vendor /app/vendor /var/www/html/vendor

# Copy built assets to public/build
RUN rm -rf /var/www/html/public/build || true
COPY --from=node-builder /app/public/build /var/www/html/public/build

# Ensure correct ownership for writable dirs
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache || true

# Copy service configs and entrypoint
COPY docker/nginx/nginx.conf /etc/nginx/nginx.conf
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

EXPOSE 80

ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]
CMD ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
