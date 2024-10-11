FROM php:8.3

RUN apt-get update -y && apt-get install -y \
    openssl \
    zip \
    unzip \
    git \
    libonig-dev \
    libzip-dev \
    libpng-dev \
    libcurl4-openssl-dev \
    pkg-config \
    libssl-dev \
    mariadb-client \
    && docker-php-ext-install pdo_mysql mbstring

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app

COPY . /app

RUN chown -R www-data:www-data /app

RUN composer install --no-interaction --prefer-dist --optimize-autoloader --verbose

RUN composer require php-open-source-saver/jwt-auth

CMD php artisan vendor:publish --provider="PHPOpenSourceSaver\JWTAuth\Providers\LaravelServiceProvider" && \
    php artisan storage:link && \
    php artisan key:generate && \
    php artisan migrate:refresh && \
    php artisan db:seed && \
    php artisan jwt:secret && \
    php artisan serve --host=0.0.0.0 --port=8181

EXPOSE 8181
