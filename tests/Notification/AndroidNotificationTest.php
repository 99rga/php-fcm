<?php

namespace Tests\Request;

use g9rga\phpFcm\src\Notification\AndroidNotification;
use PHPUnit\Framework\TestCase;

class AndroidNotificationTest extends TestCase
{
    public function testSimple()
    {
        $notification = new AndroidNotification();
        $notification->setTitle('title');
        $notification->setBody('body');
        $this->assertEquals('{"collapse_key":"","priority":"NORMAL","ttl":null,"restricted_package_name":null,"notification":{"icon":"","color":"","sound":null,"tag":"","click_action":"","body_loc_key":"","body_loc_args":[],"title_loc_key":"","title_loc_args":[]}}',
            json_encode($notification->toArray()));
    }
}
