# Веб-приложение "Заметки" (тестовая задача)

## Установка и запуск
Для работы потребуется локальный php и сервер mysql

### Установка
- git clone https://github.com/GoldBest/notes.git
- cd notes
- composer install
- npm install
- php artisan key:generate
- cp .env.example .env
- .env настройка подключения к базе
- php artisan migrate

### Запуск
- npm run dev
- php artisan serv
