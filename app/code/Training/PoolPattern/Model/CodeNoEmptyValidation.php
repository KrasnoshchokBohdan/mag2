<?php

namespace Training\PoolPattern\Model;

use Training\PoolPattern\Model\CodeValidationInterface;

class CodeNoEmptyValidation implements CodeValidationInterface
{
    public function validate(string $code): void
    {
        if ($code === "") {
            throw new \InvalidArgumentException('Code can not be empty');
        }
    }
}
