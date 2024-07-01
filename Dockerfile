FROM php:7.2-alpine3.9

WORKDIR /var/www/html

RUN apk add nodejs npm python2 g++ make

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY ./dev/start.sh /usr/local/bin/start

CMD ["sh", "-c", "chmod +x /usr/local/bin/start && start"]
