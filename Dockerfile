# Use uma imagem oficial do PHP com Apache
FROM php:8.2-apache

# Instale pacotes necessários para a extensão do PostgreSQL
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Instale o Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer
<<<<<<< HEAD
=======

# Copie os arquivos da aplicação
COPY . /var/www/html
>>>>>>> e4287bf506c097d1261e89d133d0dc578aea867d

# Defina o diretório de trabalho
WORKDIR /var/www/html

# Copie os arquivos da aplicação para o contêiner
COPY . /var/www/html

# Dê permissões corretas
RUN chown -R www-data:www-data /var/www/html \
    && a2enmod rewrite

# Instale dependências PHP
RUN composer install --no-dev --optimize-autoloader

# Exponha a porta 80 para o Apache
EXPOSE 80

# Comando para iniciar o Apache
CMD ["apache2-foreground"]

