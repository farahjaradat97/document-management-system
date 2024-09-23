FROM php:8.2.0-fpm-alpine

# Install necessary packages
RUN apk add --no-cache git curl

# PHP extensions
RUN docker-php-ext-install pdo pdo_mysql

# For composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Add a non-root user
RUN addgroup -S appgroup && adduser -S appuser -G appgroup
RUN mkdir -p /var/www/html && chown -R appuser:appgroup /var/www/html

# Copy application source
COPY ./src /var/www/html
WORKDIR /var/www/html

# Set permissions for storage and bootstrap/cache
RUN chown -R appuser:appgroup /var/www/html/storage
RUN chown -R appuser:appgroup /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage
RUN chmod -R 775 /var/www/html/bootstrap/cache

# Switch to non-root user
USER appuser
