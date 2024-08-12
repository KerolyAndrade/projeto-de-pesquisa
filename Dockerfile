# Use uma imagem oficial do PHP com Apache
FROM php:8.1-apache

# Instale extensões PHP necessárias
RUN docker-php-ext-install pdo pdo_mysql pdo_pgsql

# Instale Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copie os arquivos da aplicação
COPY . /var/www/html

# Defina o diretório de trabalho
WORKDIR /var/www/html

# Dê permissões corretas
RUN chown -R www-data:www-data /var/www/html \
    && a2enmod rewrite

# Instale dependências PHP
RUN composer install --no-dev --optimize-autoloader

# Copie o arquivo de configuração do Apache
COPY .docker/apache/000-default.conf /etc/apache2/sites-available/000-default.conf

# Exponha a porta 80 para o Apache
EXPOSE 80

# Comando para iniciar o Apache
CMD ["apache2-foreground"]

