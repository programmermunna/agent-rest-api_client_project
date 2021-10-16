FROM php:7.4-fpm

LABEL agent="agent"

RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
	libzip-dev \
    zip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

RUN docker-php-ext-install mysqli pdo pdo_mysql bcmath json zip


# Install Composer app and copying the file
RUN curl -sS https://getcomposer.org/installer​ | php -- \
    --install-dir=/usr/local/bin --filename=composer

## Copy composer bin
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Setup The working dir
# this mean on docker container we have folder with
# Name rest-api so all current project will be there
WORKDIR /rest-api

# Copy Current working dir into the the /rest-api see WORKDIR /rest-api
COPY . .

RUN composer install
