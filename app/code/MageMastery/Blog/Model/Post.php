<?php

namespace MageMastery\Blog\Model;
use MageMastery\Blog\Api\Data\PostInterface;
use MageMastery\Blog\Model\ResourceModel\Post as Postresourse;
use Magento\Framework\Model\AbstractModel;

/**
 * Class Post
 */
class Post extends AbstractModel implements PostInterface
{
    protected function _construct()
    {
        $this->_init(Postresourse::class);
    }

    public function getEmptyObject()
    {
        return 'no';
    }
}
