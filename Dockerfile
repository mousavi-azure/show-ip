FROM php:8.1-apache

RUN apt-get update && apt-get install -y \
    libcurl4-openssl-dev \
    git \
    unzip \
    && docker-php-ext-install curl \
    && curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer

COPY . /var/www/html/

RUN chown -R www-data:www-data /var/www/html/

WORKDIR /var/www/html
RUN composer install --no-dev --optimize-autoloader

RUN sed -i 's/80/5000/' /etc/apache2/ports.conf
RUN sed -i 's/:80/:5000/' /etc/apache2/sites-available/000-default.conf

RUN a2enmod rewrite

EXPOSE 5000

CMD ["apache2-foreground"]
