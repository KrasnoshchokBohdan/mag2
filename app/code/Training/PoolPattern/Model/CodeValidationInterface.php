<?php

namespace Training\PoolPattern\Model;

interface CodeValidationInterface
{
    public function validate(string $code): void;
}
