FROM php:7.4-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
 libicu-dev \
 libpq-dev \
 libpng-dev \
 libmcrypt-dev \
 git \
 unzip \
 && rm -r /var/lib/apt/lists/* \
 && docker-php-ext-configure pdo_mysql --with-pdo-mysql=mysqlnd \
 && docker-php-ext-install \
 intl \
 pcntl \
 pdo_mysql \
 gd \
 opcache

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Get latest Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer

# Set application folder
ENV APP_HOME /var/www/html

# Change uid and gid of apache to docker user uid/gid
RUN usermod -u 1000 www-data && groupmod -g 1000 www-data

# Enable apache module rewrite
RUN a2enmod rewrite
RUN a2enmod ssl
RUN a2enmod headers

# Set up apache configs and document root
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Define the command rewrite
RUN a2enmod rewrite headers

#Copy source files
COPY . $APP_HOME

# Install all PHP dependencies
RUN composer install --no-interaction

# Change ownership
RUN chown -R www-data:www-data $APP_HOME

# Install and enable xDebug
RUN pecl install xdebug && docker-php-ext-enable xdebug
