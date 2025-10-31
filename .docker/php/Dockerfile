# .docker/php/Dockerfile

FROM php:8.3-fpm

# Composerをマルチステージビルドでインストール
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# 必要なPHP拡張機能とライブラリをインストール
# RUN命令を一つにまとめ、キャッシュを削除してイメージサイズを最適化
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo pdo_pgsql pgsql zip \
    # Xdebugをインストール
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    # 不要なファイルを削除
    && apt-get clean && rm -rf /var/lib/apt/lists/* \

WORKDIR /var/www

COPY ./composer.json ./composer.lock* ./

RUN composer install --no-interaction --no-plugins --no-scripts --prefer-dist

COPY . .

RUN composer install --no-interaction --no-plugins --prefer-dist
