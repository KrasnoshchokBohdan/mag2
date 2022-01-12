<?php

namespace Order\Cancel\Model\Config\Source;

use Magento\Customer\Model\ResourceModel\Group\Collection as CustomerGroup;
use Magento\Framework\Data\OptionSourceInterface;

class CustomerGroups implements OptionSourceInterface
{
    /**
     * @var CustomerGroup
     */
    protected $customerGroup;

    /**
     * @param CustomerGroup $customerGroup
     */
    public function __construct(
        CustomerGroup $customerGroup
    ) {
        $this->customerGroup = $customerGroup;
    }

    /**
     * getCustomerGroups
     * @return array<array>
     */
    public function getCustomerGroups(): array
    {
        return $this->customerGroup->toOptionArray();
    }

    /**
     * Retrieve Custom Option array
     * @return  array<array>
     */
    public function toOptionArray(): array
    {
        return $this->getCustomerGroups();
    }
}
