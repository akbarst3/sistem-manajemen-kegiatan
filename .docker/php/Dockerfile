FROM php:8.2-fpm

# ARG untuk UID/GID agar bisa disesuaikan dari docker-compose
ARG UID=1000
ARG GID=1000

# Buat user & group 'restu'
RUN groupadd -g ${GID} restu && \
    useradd -u ${UID} -g restu -m -s /bin/bash restu

# Salin konfigurasi PHP
COPY php.ini /usr/local/etc/php/
COPY docker.conf /usr/local/etc/php-fpm.d/docker.conf
COPY .bashrc /root/

# Install dependency OS + ekstensi PHP
RUN apt-get update \
  && apt-get install -y \
    build-essential \
    zlib1g-dev \
    default-mysql-client \
    curl \
    gnupg \
    procps \
    vim \
    git \
    unzip \
    libzip-dev \
    libpq-dev \
    libicu-dev \
  && docker-php-ext-install zip pdo_mysql pdo_pgsql pgsql intl

# Install ekstensi Redis & PCOV
RUN pecl install redis && docker-php-ext-enable redis \
  && pecl install pcov && docker-php-ext-enable pcov

# (Opsional) Xdebug - uncomment jika perlu
# RUN pecl install xdebug && docker-php-ext-enable xdebug \
#   && echo ";zend_extension=xdebug" > /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# Install Node.js, NPM, Yarn
RUN curl -sL https://deb.nodesource.com/setup_20.x | bash - \
  && apt-get install -y nodejs \
  && npm install -g npm@latest \
  && npm install -g yarn

# Install Composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
  && php composer-setup.php \
  && php -r "unlink('composer-setup.php');" \
  && mv composer.phar /usr/local/bin/composer

ENV COMPOSER_ALLOW_SUPERUSER=1
ENV COMPOSER_HOME=/composer
ENV PATH=$PATH:/composer/vendor/bin

RUN composer config --global process-timeout 3600 \
  && composer global require "laravel/installer"

# (Opsional) Tambahan personalisasi
WORKDIR /root
RUN git clone https://github.com/seebi/dircolors-solarized

# Ubah workdir dan set user ke 'restu'
WORKDIR /var/www
USER restu

EXPOSE 5173

