<?php

namespace TestTasks\TaskOne\Plugins;

use \Magento\Catalog\Model\Product;

class SomeProduct
{
    protected $block;
    public function __construct(
        \TestTasks\TaskOne\Block\Index $block
    ) {
        $this->block = $block;
    }

    /** 
     * 
     * @return string
     */
    public function afterGetName(Product $subject, $result)
    {
        if ($this->block->getCurrentProduct()) {
            return $result . ' ' . $this->block->getTaskStr();
        } else {
            return $result;
        }
    }
}
