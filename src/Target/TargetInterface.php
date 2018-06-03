<?php

namespace g9rga\phpFcm\src\Target;

interface TargetInterface
{
    public function getType(): string;

    public function getValue(): string;
}
