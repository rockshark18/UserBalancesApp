#NOTE: check: docker exec -it "userbalances.app" php -v
FROM php:8.3-fpm

# opcache for 8.x
COPY ./usr/local/etc/php/conf.d/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

# Download script to install PHP extensions and dependencies
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN chmod uga+x /usr/local/bin/install-php-extensions && sync

RUN DEBIAN_FRONTEND=noninteractive apt-get update -q \
    && DEBIAN_FRONTEND=noninteractive apt-get install -qq -y \
      curl \
      git \
      zip unzip \
    && install-php-extensions \
      bcmath \
      bz2 \
      calendar \
      exif \
      gd \
      intl \
      ldap \
      mysqli \
      opcache \
      pdo_pgsql \
      xsl \
      zip \
      sockets \
    && docker-php-ext-enable sockets


# use \n to make the content into multiple lines
RUN printf "php-fpm -D\n/usr/sbin/sshd -D" >> /start.sh
RUN chmod +x /start.sh
CMD ["/start.sh"]
#------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
# composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --quiet
ENV COMPOSER_ALLOW_SUPERUSER 1

#------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

WORKDIR /app

