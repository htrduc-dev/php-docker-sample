
FROM php:8.2-fpm

# Cài extension cần thiết (pdo + pdo_mysql)
RUN docker-php-ext-install pdo pdo_mysql

# Cài Xdebug (phiên bản 3.x)
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# Thư mục làm việc
WORKDIR /var/www/html

# Copy toàn bộ project vào container
COPY . /var/www/html

# Copy file cấu hình Xdebug từ host vào container
COPY docker/php/xdebug.ini /usr/local/etc/php/conf.d/99-xdebug.ini

EXPOSE 9000