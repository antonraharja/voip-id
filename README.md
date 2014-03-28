Laravel Startup
===============

Info              | Value         | URL
----------------- | ------------- | ----------------------------------------------
Update            | 140326        |
Author            | Anton Raharja | http://antonraharja.com
License           | MIT           | http://opensource.org/licenses/MIT
Laravel           | 4.1           | http://laravel.com
Twitter Bootstrap | 3.1.1         | http://getbootstrap.com
Composer          | git           | http://getcomposer.org
IDE Helper        | git           | https://github.com/barryvdh/laravel-ide-helper


Current Features
----------------

* User login, logout, register, password recovery
* User and Profile model and UI


Usage
-----

First to update with vendor files:

```
cd ~/
git clone https://git.ngoprek.org/freelance-jobs/laravel-startup.git
cd laravel-startup
php composer.phar update
```

Next (you need to at least know howto setup db connection in Laravel):

* Create a database, for example: ```laravel_startup```
* Edit ```app/config/database.php``` and define connection to your database

Finally:

```
cd ~/laravel-startup
php artisan migrate
php artisan serve
```

And then browse **http://localhost:8000/login** use username **admin** and password **admin123**

Enjoy.
