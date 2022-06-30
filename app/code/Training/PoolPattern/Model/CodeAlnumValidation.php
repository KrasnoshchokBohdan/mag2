<?php

namespace Training\PoolPattern\Model;

use Training\PoolPattern\Model\CodeValidationInterface;

class CodeAlnumValidation implements CodeValidationInterface
{
    public function validate(string $code): void
    {
        if (!ctype_alnum($code)) {
            throw new \InvalidArgumentException('Code must only contain alphanumeric characters');
        }
    }
}
