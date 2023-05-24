FROM php:7.2-fpm-stretch
ARG TIMEZONE
ARG UID

#config userapp
RUN adduser -u ${UID} --disabled-password --gecos "" appuser \
    && mkdir /home/appuser/.ssh \
    && chown -R appuser:appuser /home/appuser/ \
    && echo "StrictHostKeyChecking no" >> /home/appuser/.ssh/config \
    && echo "export COLUMNS=300" >> /home/appuser/.bashrc \
    && echo "alias sf='php bin/console'" >> /home/appuser/.bashrc


# Install PHP extenions
RUN docker-php-ext-install \
    mysqli pdo pdo_mysql opcache mbstring

WORKDIR /var/www/html