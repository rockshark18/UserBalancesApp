#!/bin/bash

USER_EMAILS=('kuzya@gmail.com' 'vasya@gmail.com' 'petya@gmail.com')
EXPENSES=('Аптека/колёса' 'Продукты' 'Отжали' 'Посеял' 'Пробухал' 'Отдал долги' 'Развели телефонные мошенники')
INCOMES=('Зарплата' 'Выбил долги' 'Нашёл деньги' 'Прикарманил из дедушкиной пенсии')

while true; do
    USER_EMAIL=${USER_EMAILS[$((RANDOM % ${#USER_EMAILS[@]}))]}

    AMOUNT=$((RANDOM % 10001 - 5000))

    if [ $AMOUNT -lt 0 ]; then
        DESCRIPTION=${EXPENSES[$((RANDOM % ${#EXPENSES[@]}))]}
        AMOUNT="\\$AMOUNT"  # Экранируем
    else
        DESCRIPTION=${INCOMES[$((RANDOM % ${#INCOMES[@]}))]}
        AMOUNT="$AMOUNT"
    fi

    docker exec -it userbalances.app php artisan transaction:create $USER_EMAIL $AMOUNT "$DESCRIPTION"

    sleep 4
done
