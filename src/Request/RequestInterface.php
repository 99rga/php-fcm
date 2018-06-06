<?php

namespace g9rga\phpFcm\src\Request;

use Psr\Http\Message\ResponseInterface;

interface RequestInterface
{
    public function sendPost(string $url, array $headers = [], array $data = []): ResponseInterface;
}
