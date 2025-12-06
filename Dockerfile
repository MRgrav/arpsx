FROM php:8.2-cli AS base

# Reduce unnecessary file operations
RUN set -xe \
    && apt-get update \
    && apt-get install -y --no-install-recommends \
        git \
        unzip \
        curl \
        libpng-dev \
        libonig-dev \
        libxml2-dev \
        libzip-dev \
        libpq-dev \
        libcurl4-openssl-dev \
        libssl-dev \
        zlib1g-dev \
        libicu-dev \
        g++ \
        libevent-dev \
        procps \
    # Install PHP extensions in one layer
    && docker-php-ext-install \
        pdo \
        pdo_mysql \
        pdo_pgsql \
        mbstring \
        zip \
        exif \
        pcntl \
        bcmath \
        sockets \
        intl \
    # Cleanup in the same layer
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Node.js and Bun with minimal layers
RUN curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \
    && apt-get update \
    && apt-get install -y nodejs \
    && npm install -g bun \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Swoole installation
RUN pecl install swoole \
    && docker-php-ext-enable swoole

# Composer installation
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Minimize file copying and operations
COPY composer.json composer.lock ./
RUN composer install \
    --no-dev \
    --no-scripts \
    --no-autoloader \
    --prefer-dist \
    && rm -rf /root/.composer/cache

# Node dependencies with cleanup
COPY package.json bun.lock ./
RUN bun install \
    && bun cache clean

# Copy project files strategically
COPY . .

# Consolidated optimization steps
RUN composer dump-autoload --optimize \
    && bun run build \
    && php artisan storage:link \
    && php artisan config:clear \
    && php artisan route:clear \
    && php artisan view:clear \
    && chown -R www-data:www-data /var/www \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Minimal .dockerignore
RUN echo -e "\
.git\n\
.env\n\
vendor/\n\
node_modules/\n\
storage/*.log\n\
" > .dockerignore

EXPOSE 9000

# Simplified startup
CMD ["sh", "-c", "php artisan octane:start --server=swoole --host=0.0.0.0 --port=9000"]
