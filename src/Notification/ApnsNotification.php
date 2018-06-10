<?php

namespace g9rga\phpFcm\src\Notification;

use g9rga\phpFcm\src\Exception\NotImplementedException;

class ApnsNotification extends BaseNotification
{
    public function __construct()
    {
        throw new NotImplementedException();
    }

    public function toArray(): array
    {
        // TODO: Implement toArray() method.
    }
}
