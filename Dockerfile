FROM richarvey/php-apache-laravel:8.2

# Copiar el código del proyecto
COPY . /var/www/html

# Instalar dependencias de PHP
RUN composer install --no-dev --optimize-autoloader

# Configurar permisos
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Puerto estándar
EXPOSE 80