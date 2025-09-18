# Dockerfile cho ứng dụng PHP Bài Tập
FROM php:8.2-apache

# Cài đặt các extension PHP cần thiết
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Kích hoạt mod_rewrite cho Apache
RUN a2enmod rewrite

# Copy source code vào container
COPY . /var/www/html/

# Thiết lập quyền cho thư mục web
RUN chown -R www-data:www-data /var/www/html/
RUN chmod -R 755 /var/www/html/

# Cấu hình Apache để chấp nhận .htaccess
RUN echo '<Directory /var/www/html/>\n\
    Options Indexes FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted\n\
    </Directory>' > /etc/apache2/conf-available/override.conf

RUN a2enconf override

# Expose port 80
EXPOSE 80

# Khởi động Apache
CMD ["apache2-foreground"]