FROM php:8.2-cli AS base

# Combine RUN commands for efficiency
RUN apt-get update && apt-get install -y \
    git unzip curl libpng-dev libonig-dev libxml2-dev \
    libzip-dev libpq-dev libcurl4-openssl-dev libssl-dev \
    zlib1g-dev libicu-dev g++ libevent-dev procps \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql mbstring zip exif pcntl bcmath sockets intl \
    && curl -L -o swoole.tar.gz https://github.com/swoole/swoole-src/archive/refs/tags/v5.1.0.tar.gz \
    && tar -xf swoole.tar.gz \
    && cd swoole-src-5.1.0 \
    && phpize \
    && ./configure \
    && make -j$(nproc) \
    && make install \
    && docker-php-ext-enable swoole \
    && curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g bun \
    && rm -rf /var/lib/apt/lists/* swoole.tar.gz swoole-src-5.1.0

# Composer installation
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Strategic Copying
# Copy only necessary files first for better caching
COPY composer.json composer.lock artisan ./
COPY package.json bun.lock ./

# Create Laravel's basic directory structure
RUN mkdir -p bootstrap/cache storage/app storage/framework/cache/data \
    storage/framework/sessions storage/framework/views storage/logs

# Install dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist --no-scripts
RUN bun install

# Copy project files (after dependency installation)
COPY . .

# Specific storage directory handling
COPY storage/app/ /var/www/storage/app/

# Post-installation steps
RUN composer dump-autoload --optimize \
    && bun run build \
    && php artisan storage:link \
    && php artisan config:clear \
    && php artisan route:clear \
    && php artisan view:clear

# Permissions and ownership
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

EXPOSE 9000

# Startup script with error handling
CMD ["sh", "-c", "if [ -z \"$APP_KEY\" ]; then echo 'ERROR: APP_KEY is not set' && exit 1; fi && php artisan config:cache && php artisan route:cache && php artisan view:cache && php artisan octane:start --server=swoole --host=0.0.0.0 --port=9000"]
