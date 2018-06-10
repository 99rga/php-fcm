### Status
[![Build Status](https://travis-ci.org/g9rga/php-fcm.svg?branch=master)](https://travis-ci.org/g9rga/php-fcm)

# php-fcm
Php library to send push notification via google fcm with guzzle

## Usage example
```php
use g9rga\phpFcm\src\AccessToken\FileObtainer;
use g9rga\phpFcm\src\AccessToken\AccessToken;
use g9rga\phpFcm\src\Client;
use g9rga\phpFcm\src\Notification\AndroidNotification;
use g9rga\phpFcm\src\Target\TokenTarget;

/*
    To retrieve access token you can use builtin FileObtainer class
    or your own class by implementeting ObtainerInterface
*/
/*
    File content example:
    {
      "type": "service_account",
      "project_id": "project___",
      "private_key_id": "",
      "private_key": "",
      "client_email": "",
      "client_id": "",
      "auth_uri": "https://accounts.google.com/o/oauth2/auth",
      "token_uri": "https://accounts.google.com/o/oauth2/token",
      "auth_provider_x509_cert_url": "https://www.googleapis.com/oauth2/v1/certs",
      "client_x509_cert_url": ""
    }

*/
$obtainer = new FileObtainer('crentials_file_path');

$accessToken = new AccessToken($obtainer);

/*
    Optionally you can pass your own PSR-16 cache adapter to cache access token
    InMemoryCache used by default
    $accessToken->setCache();
*/


/*
    Client requires Request adapter to make requests.
    You can use GuzzleRequestAdapter or you own implementation RequestInterface
*/
$guzzleRequest = new GuzzleRequestAdapter();
$guzzleRequest->setGuzzleClient(new \GuzzleHttp\Client());

$target = new TokenTarget('client_token');

$androidNotification = new AndroidNotification();
$androidNotification->setTitle('Push notification title');
$androidNotification->setBody('Push notification body');

$client = new Client($guzzleRequest, $accessToken);
$result = $client->send($target, $androidNotification);
```


