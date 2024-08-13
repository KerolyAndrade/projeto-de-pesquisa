# Use uma imagem oficial do PHP com Apache
FROM php:8.2-apache

# Instale pacotes necessários para a extensão do PostgreSQL
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Instale Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copie os arquivos da aplicação
COPY . /var/www/html

# Defina o diretório de trabalho
WORKDIR /var/www/html

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html
    
RUN composer install 

# Exponha a porta 80 para o Apache
EXPOSE 80

# Comando para iniciar o Apache
CMD ["apache2-foreground"]
