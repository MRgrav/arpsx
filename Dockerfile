FROM dunglas/frankenphp:php8.2

# Install PHP extensions using the prepackaged helper (IPE)
RUN install-php-extensions \
    pdo_mysql \
    pdo_pgsql \
    gd \
    intl \
    zip \
    opcache \
    pcntl \
    bcmath \
    sockets

# Install system dependencies, Node.js and Bun
RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    unzip \
    curl \
    && curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g bun \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Composer installation
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copy composer files for caching
COPY composer.json composer.lock ./
RUN composer install \
    --no-dev \
    --no-scripts \
    --no-autoloader \
    --prefer-dist \
    && rm -rf /root/.composer/cache

# Copy node files and install JS dependencies
COPY package.json bun.lock ./
RUN bun install 

# Copy all project files
COPY . .

# Build assets and optimize Laravel configuration
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

# Expose port 9000 to match compose.yaml mapping
EXPOSE 9000

# Set Octane server variable
ENV OCTANE_SERVER=frankenphp

# Run Laravel Octane with FrankenPHP
CMD ["php", "artisan", "octane:start", "--server=frankenphp", "--host=0.0.0.0", "--port=9000"]
