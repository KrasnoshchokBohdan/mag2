<?php

/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Learning\Foo\Model\Attribute\Source;

class Material extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{
    /**
     * Get all options
     * @return array
     */
    public function getAllOptions()
    {
        if (!$this->_options) {
            $this->_options = [
                ['label' => __('test1'), 'value' => 'test1'],
                ['label' => __('test2'), 'value' => 'test2'],
                ['label' => __('test3'), 'value' => 'test3'],
            ];
        }
        return $this->_options;
    }
}
