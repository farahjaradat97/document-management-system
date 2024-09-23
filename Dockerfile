FROM php:8.2.0-fpm-alpine
COPY . .

RUN apk add --no-cache git curl


RUN docker-php-ext-install pdo pdo_mysql
RUN apk add --update nodejs npm

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer


WORKDIR /var/www
COPY . /var/www

COPY --chown=www-data:www-data . /var/www
 
RUN addgroup -S appgroup && adduser -S appuser -G appgroup
RUN mkdir -p /var/www && chown -R appuser:appgroup /var/www
RUN chown -R appuser:appgroup /var/www/storage
RUN chown -R appuser:appgroup /var/www/bootstrap/cache
RUN chmod -R 775 /var/www/storage
RUN chmod -R 775 /var/www/bootstrap/cache
# Switch to non-root user
USER appuser
EXPOSE 9000
CMD ["php-fpm"]