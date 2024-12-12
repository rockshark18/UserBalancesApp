#!/bin/bash

# NOTE: populate test data

docker exec -it userbalances.app php artisan migrate:refresh --force
# users
docker exec -it userbalances.app php artisan user:create kuzya kuzya@gmail.com 0000
docker exec -it userbalances.app php artisan user:create vasya vasya@gmail.com 0000
docker exec -it userbalances.app php artisan user:create petya petya@gmail.com 0000


#transactions

docker exec -it userbalances.app php artisan transaction:create petya@gmail.com '5000.00' 'Нашёл немного денег'
docker exec -it userbalances.app php artisan transaction:create petya@gmail.com '\-700.00' 'Купил корм бездомным кошкам и сигарет'
docker exec -it userbalances.app php artisan transaction:create petya@gmail.com '\-2000.00' 'Потерял в переулке'
docker exec -it userbalances.app php artisan transaction:create petya@gmail.com '\-1000.00' 'Пока искал предыдущие 2000 потерял ещё'
docker exec -it userbalances.app php artisan transaction:create petya@gmail.com '\-850.00' 'Отдал долг корешу за официальный CD `Metallica` Kill`em All'
docker exec -it userbalances.app php artisan transaction:create petya@gmail.com '850.00' 'Отдал компакт диск обратно, т.к. оказался сломанный'

docker exec -it userbalances.app php artisan transaction:create kuzya@gmail.com '7500.00' 'Получил зарплату'
docker exec -it userbalances.app php artisan transaction:create kuzya@gmail.com '\-1250.00' 'Купил струны для 8 струнной электрогитары'
docker exec -it userbalances.app php artisan transaction:create kuzya@gmail.com '\-950.00' 'Купил кабель для электрогитары'
docker exec -it userbalances.app php artisan transaction:create kuzya@gmail.com '950.00' 'Вернул кабель обратно, сильно фонит'
docker exec -it userbalances.app php artisan transaction:create kuzya@gmail.com '\-4500.00' 'Развели телефонные мошенники (('
docker exec -it userbalances.app php artisan transaction:create kuzya@gmail.com '\-400.00' 'На оставшиеся деньги купил пива сраками'

docker exec -it userbalances.app php artisan transaction:create vasya@gmail.com '10000.00' 'Зарплата'
docker exec -it userbalances.app php artisan transaction:create vasya@gmail.com '\-1000' 'Купил цветы'
docker exec -it userbalances.app php artisan transaction:create vasya@gmail.com '\-1000.00' 'Гопники отжали кошелёк вместе с цветами (('
docker exec -it userbalances.app php artisan transaction:create vasya@gmail.com '\-500' 'Купил ёщё цветы'
docker exec -it userbalances.app php artisan transaction:create vasya@gmail.com '\-100.00' 'Дал денег бомжу на районе'
docker exec -it userbalances.app php artisan transaction:create vasya@gmail.com '\-1000' 'Опять напали малолетние гопники забрали второй кошелёк'
docker exec -it userbalances.app php artisan transaction:create vasya@gmail.com '1000.00' 'Догнал этих гопников забрал кошелёк обратно'
docker exec -it userbalances.app php artisan transaction:create vasya@gmail.com '\-3000' 'Штраф участковому на месте за то что ударил гопника-малолетку'
docker exec -it userbalances.app php artisan transaction:create vasya@gmail.com '\-750.00' 'Такси домой, т.к. девушка ушла гулять с другим (с petya@gmail.com)'
docker exec -it userbalances.app php artisan transaction:create vasya@gmail.com '300' 'Кореш вернул долг'
docker exec -it userbalances.app php artisan transaction:create vasya@gmail.com '\-2000' 'Купил виски и отпраздновал своё 40-летие прямо в лифте (застрял в лифте до утра)'
