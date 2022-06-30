<?php

namespace Training\Interfaces\Model;

use Training\Interfaces\Api\Data\SupplierInterface;

class Supplier implements SupplierInterface
{

    /**
     * @var string
     */
    protected string $code;

    /**
     * @param string $code
     * @return void
     */
    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }
}
