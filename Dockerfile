# Este Dockerfile é utilizado para criar uma imagem Docker que roda uma aplicação web PHP com Apache.
# A imagem base é a php:7.4-apache, que já contém o PHP 7.4 e o servidor web Apache configurado para funcionar com o PHP.

# Utiliza a imagem oficial do PHP com Apache como ponto de partida.
FROM php:7.4-apache

RUN echo '<Directory "/var/www/html">' >> /etc/apache2/apache2.conf \
 && echo '    Options Indexes FollowSymLinks' >> /etc/apache2/apache2.conf \
 && echo '    AllowOverride None' >> /etc/apache2/apache2.conf \
 && echo '    Require all granted' >> /etc/apache2/apache2.conf \
 && echo '</Directory>' >> /etc/apache2/apache2.conf


# Instalar dependências para o MongoDB e SSL
RUN apt-get update && apt-get install -y \
        libssl-dev \
        openssl \
    && rm -rf /var/lib/apt/lists/*
# Instala as extensões mysqli, pdo e pdo_mysql do PHP.
RUN docker-php-ext-install mysqli pdo pdo_mysql
# Instale a extensão do MongoDB
RUN pecl install mongodb && docker-php-ext-enable mongodb
# Copia os arquivos da pasta atual no host para a pasta /var/www/html dentro do container.
COPY . /var/www/html/
# Expõe a porta 80 do container.
EXPOSE 80
