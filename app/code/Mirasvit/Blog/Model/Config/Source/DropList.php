<?php

namespace Mirasvit\Blog\Model\Config\Source;

class DropList implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @return array
     */
    public function toOptionArray()
    {

        return [
            ['value' => 5, 'label' => __('5')],
            ['value' => 10, 'label' => __('10')],
            ['value' => 20, 'label' => __('20')],
            ['value' => 50, 'label' => __('50')]
        ];
    }
}
