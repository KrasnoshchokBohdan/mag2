<?php

namespace Training\PoolPattern\Model;

use Training\PoolPattern\Model\CodeValidationInterface;

class CodeValidationPool
{

    /**
     * @var array|CodeValidationInterface[]
     */
    protected array $validations;

    /**
     * @param array|CodeValidationInterface[] $validations
     */
    public function __construct(array $validations)
    {
        $this->validations = $validations;
    }

    public function validate(string $code): void
    {
        foreach ($this->validations as $validation) {
            $validation->validate($code);
        }
    }
}
