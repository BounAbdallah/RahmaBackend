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

# Copier tous les fichiers dans le conteneur
COPY . /app

# S'assurer que le fichier .env existe, sinon copier .env.example
RUN cp .env.example .env

# Changer la propriété des fichiers pour l'utilisateur www-data
RUN chown -R www-data:www-data /app

# Installer les dépendances Composer
RUN composer install --no-interaction --prefer-dist --optimize-autoloader --verbose

# Installer JWT
RUN composer require php-open-source-saver/jwt-auth

# Supprimer le lien symbolique public/storage s'il existe déjà et recréer le lien
RUN rm -f public/storage && php artisan storage:link

# Publier les assets JWT et générer les clés
CMD php artisan vendor:publish --provider="PHPOpenSourceSaver\JWTAuth\Providers\LaravelServiceProvider" && \
    php artisan key:generate && \
    php artisan migrate:refresh && \
    php artisan db:seed && \
    php artisan jwt:secret && \
    php artisan serve --host=0.0.0.0 --port=8181

EXPOSE 8181
