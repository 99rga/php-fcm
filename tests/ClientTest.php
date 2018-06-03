<?php

namespace g9rga\phpFcm\tests;

use g9rga\phpFcm\src\Client;
use g9rga\phpFcm\src\Notification\AndroidNotification;
use g9rga\phpFcm\src\Target\TokenTarget;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    public function testIndex()
    {
        $client = new Client();
        $target = new TokenTarget('sss');
        $androidNotification = new AndroidNotification();
        $client->setAndroidNotification($androidNotification);
        $client->send($target);
    }
}
