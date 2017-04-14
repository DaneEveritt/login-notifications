# Laravel Login Notifications
A login notification utility for Laravel projects. Supports Laravel `5.3` and `5.4`. Designed for use with [Pterodactyl Panel](https://github.com/Pterodactyl/Panel) but should work with most Laravel applications.

This package assumes that you have queues setup, as well as support for a database notification.

### Installation
First install with composer.
```
composer require daneeveritt/login-notifications
```

Then open `config/app.php` and add the povider to the service providers array.
```
'providers' => [
    ...
    DaneEveritt\LoginNotifications\NotificationServiceProvider::class,
],
```

After installation, any login successes or failures will send the user an email.
