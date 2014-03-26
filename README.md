Laravel Startup
===============

Info              | Value         | URL
----------------- | ------------- | ----------------------------------------------
Update            | 140326        |
Author            | Anton Raharja | http://antonraharja.com
License           | MIT           | http://opensource.org/licenses/MIT
Laravel           | 4.1           | http://laravel.com
Twitter Bootstrap | 3.1.1         | http://getbootstrap.com
IDE Helper        | git           | https://github.com/barryvdh/laravel-ide-helper


Current Features
----------------

* User login, logout, register, password recovery
* User and Profile model


Usage
-----

Assumed:

* You have /usr/local/bin/composer (getcomposer.com)

```
cd ~
git clone https://git.ngoprek.org/freelance-jobs/laravel-startup.git
cd laravel-startup
composer update
```

Next:

* You have to create a database and insert ```db/laravel_startup.sql```
* You have to edit ```app/config/database.php``` and define connections

Finally:

```
cd ~/laravel-startup
php artisan serve
```

And then browse **http://localhost:8000/login** use username **admin** and password **admin123**

Enjoy.
