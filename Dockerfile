FROM php:8.4.26-cli-alpine AS builder

RUN apk add --no-cache git unzip

COPY --from=composer:2.8.6 /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY composer.json composer.lock ./

RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist

COPY . .

RUN composer dump-autoload --optimize

FROM php:8.4.26-cli-alpine

WORKDIR /var/www/html

RUN adduser -D -u 1000 appuser

COPY --from=builder /app /var/www/html

RUN cp .env.example .env && \
    php artisan key:generate

RUN chown -R appuser:appuser /var/www/html && \
    chmod -R 775 storage bootstrap/cache database

USER appuser

EXPOSE 8000

HEALTHCHECK --interval=10s --timeout=3s --start-period=3s --retries=3 \
    CMD wget --spider -q http://127.0.0.1:8000/api/tugas || exit 1

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
