# Use uma imagem oficial do PHP com Apache
FROM php:8.2-apache

# Instale pacotes necessários para a extensão do PostgreSQL e outras dependências
RUN apt-get update && apt-get install -y \
    libpq-dev \
    git \
    unzip \
    && docker-php-ext-install pdo pdo_pgsql \
    && rm -rf /var/lib/apt/lists/*

# Instale o Composer (copiando diretamente do contêiner do Composer)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Defina o diretório de trabalho
WORKDIR /var/www/html

# Copie os arquivos de configuração do Composer primeiro para otimizar o cache
COPY composer.json composer.lock /var/www/html/
COPY .env.example /var/www/html/.env

# Instale as dependências do Composer
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist --no-scripts

# Copie os arquivos da aplicação (agora todos os arquivos, exceto o .env)
COPY . /var/www/html

# Copie a configuração personalizada do Apache
COPY ./config/000-default.conf /etc/apache2/sites-available/000-default.conf

# Adicione ServerName para suprimir o erro de domínio
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Dê permissões corretas
RUN chown -R www-data:www-data /var/www/html \
    && a2enmod rewrite \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Baixar o script wait-for-it.sh
COPY wait-for-it.sh /wait-for-it.sh
RUN chmod +x /wait-for-it.sh

# Gere a chave da aplicação Laravel (caso seja necessário)
RUN php artisan key:generate

# Exponha a porta 80 para o Apache
EXPOSE 80

# Comando para iniciar o Apache
CMD ["apache2-foreground"]
