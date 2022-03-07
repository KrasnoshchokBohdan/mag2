<?php

namespace Widget\Custom\Model\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Widget\Custom\Model\ResourceModel\Blog\CollectionFactory;

class ConditionSource implements OptionSourceInterface
{
    /**
     * @var CollectionFactory
     */
    protected $collection;

    /**
     * @param CollectionFactory $collection
     */
    public function __construct(
        CollectionFactory $collection
    ) {
        $this->collection = $collection;
    }

    /**
     * Retrieve Custom Option array
     * @return  array<array>
     */
    public function toOptionArray(): array
    {
        $collection = $this->collection->create();
        $arr = [];
        foreach ($collection as $item){
            $arr[] =   ['label' => $item->getData('blog_title'), 'value' => $item->getData('conditions_serialized')];
        }
        return $arr;
    }
}
