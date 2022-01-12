<?php

namespace Order\Cancel\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Sales\Model\ResourceModel\Order\Status\Collection as OrderStatusCollection;

class OrderStatuses implements OptionSourceInterface
{
    /**
     * @var OrderStatusCollection
     */
    private $orderStatusCollection;

    /**
     * @param OrderStatusCollection $orderStatusCollection
     */
    public function __construct(OrderStatusCollection $orderStatusCollection)
    {
        $this->orderStatusCollection = $orderStatusCollection;
    }

    /**
     * @return array
     */
    public function getAllOrderStatus()
    {
        return $this->orderStatusCollection->toOptionArray();
    }

    /**
     * Retrieve Custom Option array
     * @return  array<array>
     */
    public function toOptionArray(): array
    {
        return $this->getAllOrderStatus();
    }
}
