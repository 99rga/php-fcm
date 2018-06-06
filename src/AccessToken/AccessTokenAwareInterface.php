<?php

namespace g9rga\phpFcm\src\AccessToken;

interface AccessTokenAwareInterface
{

    /**
     * @return string
     */
    public function getAccessToken(): string;

    /**
     * @return ObtainerInterface
     */
    public function getObtainer(): ObtainerInterface;
}
