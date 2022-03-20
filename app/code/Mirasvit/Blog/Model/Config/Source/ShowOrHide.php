<?php

namespace Mirasvit\Blog\Model\Config\Source;

class ShowOrHide implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @return array
     */
    public function toOptionArray()
    {

        return [
            ['value' => 1, 'label' => __('Show')],
            ['value' => 0, 'label' => __('Hide')]

        ];
    }
}
