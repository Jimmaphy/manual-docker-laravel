FROM php:8.2-apache

RUN docker-php-ext-install pdo pdo_mysql

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public 
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf 
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf 
RUN a2enmod rewrite

WORKDIR /var/www/html/