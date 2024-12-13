
![2024-12-13 02_40_19-ubu - VMware Workstation](https://github.com/user-attachments/assets/7d19ee28-2269-4ca0-9771-a009b06fa8c8)

**ПОСМОТРЕТЬ ВИДЕО НА YOUTUBE**: https://www.youtube.com/watch?v=GzHHgrKammc

**Затраченные человекочасы:** ~5 рабочих дней

**Структура:**
*	/app 			
*	/frontend		 
*	/supervisor		 
	
**Docker-контейнеры:**
*	**userbalances.app**         		- Laravel 11 backend API
*	**userbalances.frontend**    		- Vue3 SPA + Vite (dev+prod configs, 88 port)
*	**userbalances.supervisor**  		- daemon Laravel Queues/Jobs
*	**userbalances.db**        		- PostgreSQL 16
*	**userbalances.nginx**       		- Nginx для API (3080 port) 

**Tested on:**
* Windows 10 (WSL2) + Docker
* Ubuntu 22.04 + Docker

**Virtualization:**
* Docker
* docker-compose

**Backend:**
* Laravel 11
* JWT
* Laravel Queues / Jobs
* API works via Nginx *(port 3080)*
* Поиск транзакций сделан не чувствительным к регистру *(как и должно быть, то есть будет работать поиск "зАрПлАтА")*
  
**DB:**
* PostgreSQL 16
  
**Frontend:**
* Vue 3
  * JavaScript
	* SPA 
	*  Vite
	*  Styles 
		*  SCSS 
		*  Bootstrap 5
	*  Nginx *(для prod конфигурации)*
		*  port 88 *(специально на случай если 80й порт у вас занят, маппинг исправляется в docker-compose.yml, сервис frontend)*
	*  JWT токен хранится в Cookies а не в LocalStorage

**NOTES:**
*  `bcmath` vs `float`: в backend я не использую `float` для операций с balance/amount, из-за вероятности потерять точность, только bcmath *(`bcadd` и т.д.)*
*  `Laravel Queues` работают через `Supervisor` в контейнере. `Supervisor` работает как daemon, запускается вместе в контейнером
* как добавить транзакцию:

		`docker exec -it userbalances.app php artisan transaction:create vasya@gmail.com '10000.00' 'Зарплата'`
		`docker exec -it userbalances.app php artisan transaction:create vasya@gmail.com '\-1000.00' 'Гопники отжали кошелёк'`
  
Если сумма <0 то надо использовать кавычки *(я использую одинарные)* и экранирование *(слэш)* Пример: `'\-1000'`

**Запуск:**

**1. Клонируем репозиторий**
* `git clone https://github.com/rockshark18/UserBalancesApp.git`
* `cd ./UserBalancesApp/`
* `sudo chmod -R 777 ./`

**2. Запуск в фоне**
* Win10:
  * `docker-compose up -d --build`
  * `docker-compose down --volumes` (опционально)
* Ubuntu 22.04:
  * `sudo docker-compose down --volumes` (опционально)
  * `sudo docker-compose up -d --build`
		
**2.1 Реинициализируем кэш**
* Win10:
  * `docker exec -it userbalances.app php artisan config:clear`
  * `docker exec -it userbalances.app php artisan config:cache`
* Ubuntu 22.04:
  * `sudo docker exec -it userbalances.app php artisan config:clear`
  * `sudo docker exec -it userbalances.app php artisan config:cache`

**2.2 Перезапуск**
* Win10: 	
  * `docker-compose down`
  * `docker-compose up -d`
* Ubuntu 22.04:
  * `sudo docker-compose down`
  * `sudo docker-compose up -d`

**3.1 Запускаем скрипт инициализации БД** *(force-migrate и feed тестовых данных - пользователи, балансы и тестовые транзакции и тд.)*
   в терминале видим email'ы созданных пользователей *(для дальнейшего ручного добавления транзакции для пункта 4.1)*   
   Этот же скрипт если повторно запустить, обнулит базу данных и заново проинициализирует заново тестовыми данными

*	Win10:
    * `chmod +x ./init_db.sh`       
    *	`bash ./init_db.sh`
* Ubuntu 22.04:
   * `chmod +x ./init_db.sh`
   * `sudo ./init_db.sh` 
		
Пользователи (логины) добавятся автоматически в этом скрипте. Login/Pass:

* vasya@gmail.com / 0000
* petya@gmail.com / 0000
* kuzya@gmail.com / 0000

Пароль у всех одинаковый: 0000 *(4 нуля)*

И добавятся тестовые транзакции *(разумеется через Laravel Queue/Jobs + Supervisor)*
		
**4. Запускаем скрипт который в цикле раз в 2 секунды добавляет** *(через Laravel Queue/Jobs + Supervisor)* рандомному пользователю рандомную тразакцию
* Win10:
  * `chmod +x ./loop_random_transactions.sh`
  * `bash ./loop_random_transactions.sh`
* Ubuntu 22.04:
  * `chmod +x ./loop_random_transactions.sh`
  * `sudo ./loop_random_transactions.sh`

ИЛИ:

**4.1. Можно создавать транзакции вручную** *(список email'ов пользователей брать из списка который вернёт скрипт п.3)*
	> `docker exec -it userbalances.app php artisan transaction:create vasya@gmail.com '\-1000' 'Отжали кошелек в маршрутке'`
	В этом случае тразакция создается тоже черещ Laravel Queue

По транзакциям с суммой, превышающей баланс: как и требуется в условии задачи отрицательные транзакции с суммой 
превышающие баланс оказываются в таблице 'failed_jobs' с заданным мной исключением 
	'Insufficient balance. Abort' *(недостаточно средств)*
	Вот пример текста из таблицы:
	
	Exception: CreateTransactionJob error: 
	> TransactionService.createTransaction
	> UserBalanceService.incrementBalance
	Insufficient balance. Abort in /app/app/Jobs/CreateTransactionJob.php:33

Как и должно быть

**5. Заходим в приложение**
* http://127.0.0.1:88/
* Login: vasya@gmail.com
* Pass: 0000

**ВАЖНО! Если не отображются транзакции (было под Ubuntu) надо перезапустить и перезайти в приложение**
* Win10: 	
  * `docker-compose down`
  * `docker-compose up -d`
* Ubuntu 22.04:
  * `sudo docker-compose down`
  * `sudo docker-compose up -d`


