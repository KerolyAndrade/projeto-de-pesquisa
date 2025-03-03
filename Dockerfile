# Use uma imagem oficial do PHP com Apache
FROM php:8.2-apache

# Atualize e instale dependências do sistema, incluindo coreutils para chmod
RUN apt-get update && apt-get install -y \
    libpq-dev \
    git \
    unzip \
    curl \
    coreutils \
    && docker-php-ext-install pdo pdo_pgsql \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Instale o Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Instale Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && \
    apt-get install -y nodejs && \
    rm -rf /var/lib/apt/lists/*

# Habilitar mod_rewrite no Apache
RUN a2enmod rewrite

# Defina o diretório de trabalho
WORKDIR /var/www/html

# Copie o projeto para o container
COPY . .

# Defina permissões corretas para as pastas necessárias
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Instale as dependências do Composer e do npm
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist && \
    npm install && \
    npm run production

# Copie e configure o ambiente
COPY .env.example .env

# Copie a configuração do Apache
COPY ./config/000-default.conf /etc/apache2/sites-available/000-default.conf

# Exponha a porta 80
EXPOSE 80

# Comando padrão para iniciar o Apache
CMD ["apache2-foreground"]
