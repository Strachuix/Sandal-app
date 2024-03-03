FROM php:8.1-apache

RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

COPY 000-default.conf /etc/apache2/sites-available/000-default.conf

RUN apt-get update && apt-get upgrade -y
RUN apt-get update && apt-get install -y cron

RUN chmod -R 777 /var/www/html
# RUN echo "1 0 * * 1 /ścieżka/do/php /ścieżka/do/twojego/pliku.php" > /etc/cron.d/my-cron-job
# CMD cron && tail -f /dev/null

RUN a2enmod rewrite