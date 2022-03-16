FROM php:fpm

RUN apt-get update

RUN apt-get install -y git libzip-dev zip unzip \
    && docker-php-ext-install zip

RUN docker-php-ext-install pdo_mysql

RUN apt-get install -y libicu-dev \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl

RUN apt-get install -y libfreetype6-dev libjpeg62-turbo-dev libpng-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd

ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_NO_INTERACTION 1
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
  #&& php -r "if (hash_file('sha384', 'composer-setup.php') === '48e3236262b34d30969dca3c37281b3b4bbe3221bda826ac6a9a62d6444cdb0dcd0615698a5cbe587c3f0fe57a54d8f5') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" \
  && php composer-setup.php \
  && php -r "unlink('composer-setup.php');" \
  && mv composer.phar /usr/local/bin/composer
CMD php-fpm