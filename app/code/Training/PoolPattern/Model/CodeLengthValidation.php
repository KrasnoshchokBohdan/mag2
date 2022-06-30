<?php

namespace Training\PoolPattern\Model;

use Training\PoolPattern\Model\CodeValidationInterface;

class CodeLengthValidation implements CodeValidationInterface
{
    public function validate(string $code): void
    {
        if (strlen($code) > 10) {
            throw new \InvalidArgumentException('Code must be more than 9 characters');
        }
    }
}
