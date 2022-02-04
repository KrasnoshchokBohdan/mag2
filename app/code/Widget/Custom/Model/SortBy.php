<?php

namespace Widget\Custom\Model;

use Magento\Framework\Data\OptionSourceInterface;


class SortBy implements OptionSourceInterface
{

    public function toOptionArray()
    {
        return [
            ['value' => 'id', 'label' => __('Product Id')],
            ['value' => 'name', 'label' => __('Product Name')],
            ['value' => 'price', 'label' => __('Product Price')],
        ];
    }
}
