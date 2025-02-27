# Use uma imagem oficial do PHP com Apache
FROM php:8.2-apache

# Atualize e instale dependências
RUN apt-get update --no-cache && apt-get install -y \
    libpq-dev \
    git \
    unzip \
    curl \
    && docker-php-ext-install pdo pdo_pgsql \
    && apt-get autoremove -y --purge \
    && rm -rf /var/lib/apt/lists/*

# Instale o Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Instale Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && \
    apt-get install -y nodejs

# Habilitar mod_rewrite no Apache
RUN a2enmod rewrite

# Defina variáveis de ambiente
ENV APACHE_DOCUMENT_ROOT /var/www/html
ENV PHP_INI_DIR /usr/local/etc/php

# Defina o diretório de trabalho
WORKDIR ${APACHE_DOCUMENT_ROOT}

# Copie os arquivos do projeto
COPY . ${APACHE_DOCUMENT_ROOT}
COPY .env.example ${APACHE_DOCUMENT_ROOT}/.env

# Instale dependências do Composer
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist --no-scripts

# Configure permissões necessárias
RUN chown -R www-data:www-data ${APACHE_DOCUMENT_ROOT} && \
    chmod -R 775 ${APACHE_DOCUMENT_ROOT}/storage ${APACHE_DOCUMENT_ROOT}/bootstrap/cache ${APACHE_DOCUMENT_ROOT}/public

# Copie a configuração do Apache
COPY ./config/000-default.conf /etc/apache2/sites-available/000-default.conf

# Baixe e configure o script wait-for-it.sh
COPY wait-for-it.sh /wait-for-it.sh
RUN chmod +x /wait-for-it.sh

# Exponha a porta 80
EXPOSE 80

# Comando padrão para iniciar o Apache
CMD ["apache2-foreground"]
