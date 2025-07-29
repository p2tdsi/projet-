FROM php:8.1-apache

ENV DEBIAN_FRONTEND=noninteractive

RUN echo "deb http://mirror.marwan.ma/debian bookworm main" > /etc/apt/sources.list && \
    echo "deb http://mirror.marwan.ma/debian bookworm-updates main" >> /etc/apt/sources.list && \
    echo "deb http://security.debian.org/debian-security bookworm-security main" >> /etc/apt/sources.list && \
    apt-get update && \
    apt-get install -y --no-install-recommends \
        libpq-dev \
        libsqlite3-dev \
    && docker-php-ext-install pdo pdo_sqlite \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

COPY . .

EXPOSE 80

CMD ["apache2-foreground"]




