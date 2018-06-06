<?php

namespace g9rga\phpFcm\src\AccessToken;

interface ObtainerInterface
{
    public function getAccessToken(): string;

    public function getAccountType(): string;

    public function getClientId(): string;

    public function getClientEmail(): string;

    public function getPrivateKey(): string;

    public function getProjectName(): string;
}
