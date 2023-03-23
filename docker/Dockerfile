# Utilisez une image de base avec PHP et Apache
FROM php:7.4-apache

# Mettez à jour et installez les paquets nécessaires
RUN apt-get update && \
    apt-get upgrade -y && \
    apt-get install -y git libzip-dev zip unzip && \
    docker-php-ext-install zip

# Installez l'extension MongoDB pour PHP
RUN pecl install mongodb && \
    docker-php-ext-enable mongodb

# Activez les modules Apache nécessaires
RUN a2enmod rewrite

# Copiez les fichiers de configuration
COPY ./apache2.conf /etc/apache2/
COPY ./php.ini /usr/local/etc/php/

# Copiez le contenu de votre site dans le dossier /var/www/html
COPY ./src/ /var/www/html/

# Exposez le port 80 pour Apache
EXPOSE 80

# Démarrer Apache
CMD ["apache2-foreground"]
