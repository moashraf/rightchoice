FROM php:8.2-fpm

# تثبيت الباكجات المطلوبة + مكتبات تشغيل Laravel الشائعة
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    p7zip-full \
    libzip-dev \
    curl \
    default-libmysqlclient-dev \
    libxml2-dev \
    libonig-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    && docker-php-ext-configure zip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        zip \
        pdo_mysql \
        mysqli \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
    && rm -rf /var/lib/apt/lists/*

# تثبيت Composer
RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/local/bin \
    --filename=composer

WORKDIR /var/www/html
