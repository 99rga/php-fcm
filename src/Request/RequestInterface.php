<?php

namespace g9rga\phpFcm\src\Request;

use Psr\Http\Message\ResponseInterface;

interface RequestInterface
{
    public function post(string $url, array $headers = [], array $data = []): ResponseInterface;

    public function get(string $url, array $headers = [], array $data = []): ResponseInterface;
}
