<?php

namespace Training\Interfaces\Model;

use Training\Interfaces\Api\Data\SupplierInterface;
use Training\Interfaces\Api\Data\SupplierInterfaceFactory;
use Training\Interfaces\Api\SupplierRepositoryInterface;
use Training\Interfaces\Model\CodeValidationInterface;

class SupplierRepository implements SupplierRepositoryInterface
{
    /**
     * @var SupplierInterfaceFactory
     */
    protected SupplierInterfaceFactory $supplierFactory;

    /**
     * @var CodeValidationInterface
     */
    protected CodeValidationInterface $codeValidation;

    /**
     * @param SupplierInterfaceFactory $supplierFactory
     * @param CodeValidationInterface $codeValidation
     */
    public function __construct(
        SupplierInterfaceFactory $supplierFactory,
        CodeValidationInterface $codeValidation
    ) {
        $this->codeValidation = $codeValidation;
        $this->supplierFactory = $supplierFactory;
    }

    public function createNew(string $code): SupplierInterface
    {
        $this->codeValidation->validate($code);
        $supplier = $this->supplierFactory->create();
        $supplier->setCode($code);
        return $supplier;
    }
}
