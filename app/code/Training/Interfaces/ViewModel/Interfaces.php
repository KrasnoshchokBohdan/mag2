<?php

namespace Training\Interfaces\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Training\Interfaces\Api\SupplierRepositoryInterface;

class Interfaces implements ArgumentInterface
{
    /**
     * @var SupplierRepositoryInterface
     */
    private SupplierRepositoryInterface $supplierRepository;

    public function __construct(SupplierRepositoryInterface $supplierRepository)
    {
        $this->supplierRepository = $supplierRepository;
    }

    /**
     * @return string
     */
    public function getSupplierCode(): string
    {
        return $this->supplierRepository->createNew('ABC-123')->getCode();
    }

}
