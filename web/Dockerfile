FROM php:5.6-apache
COPY ./*.php /var/www/html/
RUN docker-php-ext-install mysqli
EXPOSE 80
