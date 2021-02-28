## Установка
Утсановка пакета
```cmd
composer require ozycast/service-time-calendar
```
Добавить провайдер в файл config/app.php
```php
'providers' => [
    ...

    ServiceTime\Calendar\CalendarServiceProvider::class,
]
```
Публикуем ресурсы пакета
```cmd
php artisan vendor:publish --force --provider="ServiceTime\Calendar\CalendarServiceProvider"
```
Выводим календарь на страницу
```blade
@include('service-time-calendar::_calendar')
```