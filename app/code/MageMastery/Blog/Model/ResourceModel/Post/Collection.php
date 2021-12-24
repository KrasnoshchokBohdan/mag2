<?php

namespace MageMastery\Blog\Model\ResourceModel\Post;

use MageMastery\Blog\Model\Post;
use \MageMastery\Blog\Model\ResourceModel\Post as Postresource;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class Collection
 */
class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(Post::class, Postresource::class);
    }
}
