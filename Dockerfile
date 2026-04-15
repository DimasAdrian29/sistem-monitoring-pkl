FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libicu-dev \
    libzip-dev \
    # Tambahkan library pendukung gambar di bawah ini:
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libwebp-dev

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# --- BAGIAN KRUSIAL: Konfigurasi GD agar support JPEG & WebP ---
RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd intl zip

# COPY file php.ini yang baru kita buat tadi
COPY php.ini /usr/local/etc/php/conf.d/custom.ini

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . /var/www

# --- TAMBAHAN: Buat direktori sertifikats ---
RUN mkdir -p /var/www/storage/app/public/sertifikats

# Ubah ownership agar Laravel (via www-data) bisa menulis ke dalam folder storage
RUN chown -R www-data:www-data /var/www

EXPOSE 9000
CMD ["php-fpm"]
# FROM php:8.2-fpm

# # Install system dependencies
# RUN apt-get update && apt-get install -y \
#     git \
#     curl \
#     libpng-dev \
#     libonig-dev \
#     libxml2-dev \
#     zip \
#     unzip \
#     libicu-dev \
#     libzip-dev \
#     # Tambahkan library pendukung gambar di bawah ini:
#     libfreetype6-dev \
#     libjpeg62-turbo-dev \
#     libwebp-dev

# # Clear cache
# RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# # --- BAGIAN KRUSIAL: Konfigurasi GD agar support JPEG & WebP ---
# RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp

# # Install PHP extensions
# RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd intl zip

# # COPY file php.ini yang baru kita buat tadi
# COPY php.ini /usr/local/etc/php/conf.d/custom.ini

# # Get latest Composer
# COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# WORKDIR /var/www

# COPY . /var/www
# RUN chown -R www-data:www-data /var/www

# EXPOSE 9000
# CMD ["php-fpm"]
