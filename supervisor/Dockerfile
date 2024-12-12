FROM php:8.3-cli

# Установка Supervisor и необходимых инструментов
RUN apt-get update && apt-get install -y \
    supervisor \
    libpq-dev \
    libzip-dev \
    unzip \
    git && \
    docker-php-ext-install \
    bcmath \
    pdo \
    pdo_pgsql \
    zip && \
    mkdir -p /etc/supervisor/conf.d /var/log/supervisor

# Рабочая директория
WORKDIR /app

# Запуск Supervisord
CMD ["supervisord", "-c", "/etc/supervisor/supervisord.conf"]
