# Use uma imagem oficial do PHP com Apache
FROM php:8.2-apache

# Instale pacotes necessários para a extensão do PostgreSQL e outras dependências
RUN apt-get update && apt-get install -y \
    libpq-dev \
    git \
    unzip \
    && docker-php-ext-install pdo pdo_pgsql

# Instale o Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Defina o diretório de trabalho
WORKDIR /var/www/html

# Copie o arquivo Composer e o arquivo .env primeiro para aproveitar o cache de build do Docker
COPY composer.json composer.lock /var/www/html/
COPY .env.example /var/www/html/.env

# Instale dependências PHP
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist --no-scripts

# Copie os arquivos da aplicação
COPY . /var/www/html

# Dê permissões corretas
RUN chown -R www-data:www-data /var/www/html \
    && a2enmod rewrite \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Gere a chave da aplicação Laravel
RUN php artisan key:generate

# Exponha a porta 80 para o Apache
EXPOSE 80

# Comando para iniciar o Apache
CMD ["apache2-foreground"]



