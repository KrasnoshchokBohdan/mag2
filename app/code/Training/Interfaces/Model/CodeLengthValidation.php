<?php

namespace Training\Interfaces\Model;

use Training\Interfaces\Model\CodeValidationInterface;

class CodeLengthValidation implements CodeValidationInterface
{
    public function validate(string $code): void
    {
        if (strlen($code) > 9) {
            throw new \InvalidArgumentException('Code must be more than 9 characters');
        }
    }
}
