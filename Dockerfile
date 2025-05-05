FROM php:8.2-apache

# Copier les fichiers PHP dans le conteneur
COPY . /var/www/html/

# Donner les bons droits
RUN chown -R www-data:www-data /var/www/html
