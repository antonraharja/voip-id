Laravel Startup
===============

Info              | Value          | URL
----------------- | -------------- | ----------------------------------------------
Update            | 141008         |
Latest version    | 1.0.2          |
Author            | Anton Raharja  | http://antonraharja.com
Co. Author        | Yuliana Rahman | http://rahman.web.id
License           | MIT            | http://opensource.org/licenses/MIT
Laravel           | 4.1.26         | http://laravel.com
Twitter Bootstrap | 3.1.1          | http://getbootstrap.com
Composer          | git            | http://getcomposer.org
IDE Helper        | git            | https://github.com/barryvdh/laravel-ide-helper


Current Features
----------------

* User login, logout, register, password recovery
* User and Profile model and UI


Usage
-----

First is to get laravel-startup and vendor files:

```
cd ~/
git clone https://github.com/antonraharja/laravel-startup.git
cd laravel-startup
php composer.phar update
```

Next (you need to at least know howto setup db connection in Laravel):

* Create a database, for example: ```laravel_startup```
* Edit ```app/config/database.php``` and define connection to your database

Finally, for demo or development purposes only, serve it:

```
cd ~/laravel-startup
php artisan migrate
php artisan serve
```

Next, browse **http://localhost:8000/init** until init done.

Last, browse **http://localhost:8000/login** use username **admin** and password **admin123**

Enjoy.
