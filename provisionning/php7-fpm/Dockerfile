FROM php:7.1-fpm

# Set timezone
RUN rm /etc/localtime \
    && ln -s /usr/share/zoneinfo/Europe/Paris /etc/localtime

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip

# install xdebug
RUN pecl install xdebug-2.5.0 \
    && docker-php-ext-enable xdebug

# Prepare installation of an upgraded version of ICU
RUN curl -sS -o /tmp/icu.tar.gz -L http://download.icu-project.org/files/icu4c/57.1/icu4c-57_1-src.tgz \
    && tar -zxf /tmp/icu.tar.gz -C /tmp \
    && cd /tmp/icu/source \
    && ./configure --prefix=/usr/local \
    && make \
    && make install \
    && docker-php-ext-configure intl --with-icu-dir=/usr/local

# Type docker-php-ext-install to see available extensions
RUN docker-php-ext-install bcmath hash intl json mbstring opcache pcntl pdo pdo_mysql

ADD php.ini /usr/local/etc/php/
RUN echo 'alias sf="php bin/console"' >> ~/.bashrc

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

ENTRYPOINT []

RUN echo "Check install" \
    && "date" \
    && composer --version

RUN sed -ri 's/^www-data:x:33:33:/www-data:x:1000:1000:/' /etc/passwd

USER www-data

WORKDIR /var/www/myapp
CMD ["php-fpm"]
