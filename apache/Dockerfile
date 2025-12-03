FROM httpd:2.4.65-alpine

# Instalar PHP y extensiones necesarias
RUN apk update && apk add --no-cache \
    php \
    php-apache2 \
    php-mysqli \
    php-pdo_mysql \
    php-pecl-redis \
    php-json \
    php-session \
    php-ctype \
    openssl \
    curl

# Enlace para que Apache encuentre PHP
RUN ln -sf /usr/lib/apache2/mod_php*.so /usr/lib/apache2/mod_php.so

# Certificados SSL
RUN mkdir -p /usr/local/apache2/conf/certs && \
    openssl req -x509 -nodes -days 365 -newkey rsa:2048 \
    -keyout /usr/local/apache2/conf/certs/server.key \
    -out /usr/local/apache2/conf/certs/server.crt \
    -subj "/C=ES/ST=Spain/L=Barcelona/O=ProjecteFinal/CN=*.local"

# Carpetas
RUN mkdir -p /var/www/localhost/htdocs/frontend && \
    mkdir -p /var/www/localhost/htdocs/api

WORKDIR /var/www/localhost/htdocs