<?php

namespace Tests\Request;

use g9rga\phpFcm\src\Request\GuzzleRequestAdapter;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

class GuzzleRequestAdapterTest extends TestCase
{

    public function testPost()
    {
        $url = 'ss';
        $headers = ['a' => 1];
        $data = ['t' => 2];

        $response = $this->getMockBuilder(ResponseInterface::class)->getMock();
        $guzzleClientMock = $this->getMockBuilder(Client::class)
            ->setMethods(['post'])
            ->getMock();
        $guzzleClientMock->expects($this->once())->method('post')
            ->with(
                $this->equalTo($url),
                $this->equalTo([
                    'headers' => $headers,
                    'json' => ['message' => $data]
                ])
            )->willReturn($response);
        $adapter = new GuzzleRequestAdapter();
        $adapter->setGuzzleClient($guzzleClientMock);
        $adapter->post($url, $headers, $data);
    }
}
