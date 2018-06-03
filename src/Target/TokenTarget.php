<?php

namespace g9rga\phpFcm\src\Target;

class TokenTarget implements TargetInterface
{
    /**
     * @var string
     */
    private $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return 'token';
    }

    public function getValue(): string
    {
        return $this->token;
    }
}
