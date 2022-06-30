<?php

namespace Training\Interfaces\Api\Data;


interface SupplierInterface
{
    public function setCode(string $code): void;

    public function getCode(): string;
}
