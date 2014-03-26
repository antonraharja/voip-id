Laravel Startup
===============

Data              | Value
----------------- | -----------------
Update            | 140326
Author            | Anton Raharja
License           | MIT
Laravel           | 4.1
Twitter Bootstrap | 3.1.1


Features
--------

* User login, logout, register, password recovery
* User and Profile model


Usage
-----

Assumed:

* You have /usr/local/bin/composer (getcomposer.com)
* Your web document root is /var/www (Debian, Ubuntu and friends)

```
cd /var/www
git clone https://git.ngoprek.org/freelance-jobs/laravel-startup.git
cd laravel-startup
composer update
```

Next:

* You have to create a database and insert ```db/laravel_startup.sql```
* You have to edit ```app/config/database.php``` and define connections

Finally:

```
php artisan serve
```

And then browse **http://localhost:8000/login** use username **admin** and password **admin123**
