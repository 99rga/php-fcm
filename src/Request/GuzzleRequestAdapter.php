<?php

namespace g9rga\phpFcm\src\Request;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class GuzzleRequestAdapter implements RequestInterface
{
    /**
     * @var Client
     */
    private $guzzleClient;

    /**
     * @param string $url
     * @param array  $headers
     * @param array  $data
     *
     * @return ResponseInterface
     */
    public function post(string $url, array $headers = [], array $data = []): ResponseInterface
    {
        return $this->getGuzzleClient()->post($url, [
            'headers' => [
                $headers,
            ],
            'json'    => ['message' => $data],
        ]);
    }

    /**
     * @param string $url
     * @param array  $headers
     * @param array  $data
     *
     * @return ResponseInterface
     */
    public function get(string $url, array $headers = [], array $data = []): ResponseInterface
    {
    }

    /**
     * @return Client
     */
    public function getGuzzleClient(): Client
    {
        return $this->guzzleClient;
    }

    /**
     * @param Client $guzzleClient
     *
     * @return $this
     */
    public function setGuzzleClient(Client $guzzleClient)
    {
        $this->guzzleClient = $guzzleClient;

        return $this;
    }
}
