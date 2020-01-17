FROM php:5.6.33-apache

RUN a2enmod rewrite

COPY ./ /Applications/XAMPP/xamppfiles/htdocs

RUN service apache2 restart