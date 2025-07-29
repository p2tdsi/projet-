FROM php:8.1-apache
WORKDIR /var/www/html
COPY . .
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo pdo_sqlite
EXPOSE 80
CMD ["apache2-foreground"]
