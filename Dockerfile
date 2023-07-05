FROM docker.productsup.com/cde/cde-php-cli-base:8.2

COPY src/ ./src
COPY config/ ./config
COPY app.php composer.json composer.lock ./

ARG COMPOSER_AUTH=local
RUN composer install --no-dev

CMD ["php", "app.php"]
