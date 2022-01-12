<?php

namespace Order\Cancel\Model\ResourceModel\Blog;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Order\Cancel\Model\Blog as BlogModel;
use Order\Cancel\Model\ResourceModel\Blog as BlogResourceModel;

class Collection extends AbstractCollection
{
    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(BlogModel::class, BlogResourceModel::class);
    }
}
