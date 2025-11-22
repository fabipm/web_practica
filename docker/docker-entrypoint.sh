#!/bin/bash
set -e

# If SSL cert/key are provided via env vars, write them to disk
if [ -n "$SSL_CERT" ] && [ -n "$SSL_KEY" ]; then
  mkdir -p /etc/ssl/nginx
  echo "$SSL_CERT" > /etc/ssl/nginx/nginx.crt
  echo "$SSL_KEY" > /etc/ssl/nginx/nginx.key
  chmod 600 /etc/ssl/nginx/nginx.key || true
fi

# Ensure storage and cache directories are writable by www-data
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache || true
chmod -R u+rwX /var/www/html/storage /var/www/html/bootstrap/cache || true

# Optional: run migrations if requested (set APP_MIGRATE=true)
if [ "$APP_MIGRATE" = "true" ]; then
  if [ -f /var/www/html/artisan ]; then
    echo "Running migrations..."
    php /var/www/html/artisan migrate --force || true
  fi
fi

# Allow container to be started with custom commands
if [ "$1" = "" ] || [ "$1" = "/usr/bin/supervisord" ] || [ "$1" = "supervisord" ]; then
  exec /usr/bin/supervisord -n -c /etc/supervisor/conf.d/supervisord.conf
else
  exec "$@"
fi
