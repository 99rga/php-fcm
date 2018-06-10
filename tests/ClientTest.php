<?php

namespace Tests;

use g9rga\phpFcm\src\AccessToken\AccessTokenAwareInterface;
use g9rga\phpFcm\src\AccessToken\ObtainerInterface;
use g9rga\phpFcm\src\Client;
use g9rga\phpFcm\src\Notification\AndroidNotification;
use g9rga\phpFcm\src\Request\RequestInterface;
use g9rga\phpFcm\src\Target\TokenTarget;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    public function testSend()
    {
        $requestMock = $this->getMockBuilder(RequestInterface::class)->getMock();
        $requestMock->expects($this->once())->method('post')
            ->with(
                $this->equalTo(sprintf(Client::API_URL, 'ss')),
                $this->equalTo([
                    'Authorization' => 'Bearer token',
                    'Content-Type' => 'application/json'
                ]),
                $this->callback(function (array $data) {
                    $this->assertEquals('{"token":"ss","notification":{"title":"","body":""},"android":{"collapse_key":"","priority":"NORMAL","ttl":null,"restricted_package_name":null,"notification":{"icon":"","color":"","sound":null,"tag":"","click_action":"","body_loc_key":"","body_loc_args":[],"title_loc_key":"","title_loc_args":[]}}}', json_encode($data));
                    return true;
                })
            );
        $accessTokenMock = $this->getMockBuilder(AccessTokenAwareInterface::class)->getMock();
        $accessTokenMock->method('getAccessToken')->willReturn('token');
        $obtainer = $this->getMockBuilder(ObtainerInterface::class)->getMock();
        $obtainer->method('getProjectName')->willReturn('ss');
        $accessTokenMock->method('getObtainer')->willReturn($obtainer);
        $target = new TokenTarget('ss');
        $notification = new AndroidNotification();
        $client = new Client($requestMock, $accessTokenMock);
        $client->send($target, $notification);
    }
}