### Status
[![Build Status](https://travis-ci.org/g9rga/php-fcm.svg?branch=master)](https://travis-ci.org/g9rga/php-fcm)

# php-fcm
Php library to send push notification via google fcm with guzzle

## Usage example
```php
$apiKey = 'YOUR_SERVER_KEY';
$client = new Client($apiKey);

$notification = new AndroidNotification();
$target = new TokenTarget('CLIENT_TOKEN');

$client->send($target, $notification);
```


