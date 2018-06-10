<?php

namespace Tests\Request;

use g9rga\phpFcm\src\Target\TokenTarget;
use PHPUnit\Framework\TestCase;

class TokenTargetTest extends TestCase
{
    public function testIndex()
    {
        $token = 'ss';
        $targetToken = new TokenTarget($token);
        $this->assertEquals('token', $targetToken->getType());
        $this->assertEquals($token, $targetToken->getValue());
    }
}
