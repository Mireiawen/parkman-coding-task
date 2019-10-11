FROM "php:7.3-apache"

# Set up the Apache configuration
ENV APACHE_DOCUMENT_ROOT "/app/public"
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Install composer
COPY --from=composer /usr/bin/composer /usr/bin/composer

# Make sure apt is up to date
RUN \
	apt-get "update"

# Install zip support for composer
RUN \
        apt-get -y install "libz-dev" "libzip-dev" "unzip" && \
        docker-php-ext-install "zip"

# Install MySQLi
RUN \
	docker-php-ext-install "mysqli"

# Install XDebug
RUN \
        pecl install "xdebug" && \
        docker-php-ext-enable "xdebug"
COPY "utils/xdebug.ini" "/usr/local/etc/php/conf.d/xdebug.ini"

# Install the application itself
RUN \
	mkdir "/app"

WORKDIR "/app"
COPY "." "/app"

# Update the composer
RUN \
	cd "/app" && \
	composer "install" --no-dev
