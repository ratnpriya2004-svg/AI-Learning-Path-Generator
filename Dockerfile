FROM php:8.2-apache

RUN docker-php-ext-install mysqli pdo pdo_mysql

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . /var/www/html/

RUN composer install --no-dev --optimize-autoloader

RUN a2enmod rewrite

EXPOSE 80

CMD ["apache2-foreground"]