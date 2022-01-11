<?php

namespace Order\Cancel\Model;

use Magento\Framework\Model\AbstractModel;
use Order\Cancel\Model\ResourceModel\Blog as BlogResourceModel;

class Blog extends \Magento\Framework\Model\AbstractModel
{
    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(BlogResourceModel::class);
    }
}
