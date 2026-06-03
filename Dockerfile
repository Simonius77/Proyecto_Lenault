FROM php:8.2-apache

# Instalar extensiones necesarias
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Habilitar mod_rewrite de Apache para URLs amigables
RUN a2enmod rewrite

# Copiar el contenido del proyecto al contenedor
COPY . /var/www/html/

# Dar permisos al directorio de imagenes (si es necesario escritura)
RUN chown -R www-data:www-data /var/www/html/Imagenes
