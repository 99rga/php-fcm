<?php

namespace g9rga\phpFcm\src\Request;

use g9rga\phpFcm\src\Exception\NotImplementedException;
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
            'headers' => $headers,
            'json'    => ['message' => $data],
        ]);
    }

    /**
     * @param string $url
     * @param array  $headers
     * @param array  $data
     * @throws NotImplementedException
     * @return ResponseInterface
     */
    public function get(string $url, array $headers = [], array $data = []): ResponseInterface
    {
        throw new NotImplementedException();
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
