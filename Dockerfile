FROM php:8.1-apache

# Install MySQL PDO extension (required for database connection)
RUN docker-php-ext-install pdo pdo_mysql

# Copy project files
COPY . /var/www/html/

# Create logs directory for production error logging
RUN mkdir -p /var/www/html/logs && \
    chown -R www-data:www-data /var/www/html && \
    a2enmod rewrite

EXPOSE 80