FROM php:5.4-apache

USER root
WORKDIR /var/www/html

COPY . .

RUN chown -R www-data:www-data /var/www/html && a2enmod rewrite

RUN apt-get update && apt-get install -y --force-yes vim unzip curl php5-mysql php5-gd
RUN docker-php-ext-install pdo_mysql pdo mysqli
RUN chmod 777 -R app lib

# Clear cache
# RUN apt-get clean && rm -rf /var/lib/apt/lists/*

EXPOSE 80
