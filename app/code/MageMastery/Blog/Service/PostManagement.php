<?php

namespace MageMastery\Blog\Service;

use MageMastery\Blog\Api\Data\PostInterface;
use MageMastery\Blog\Api\PostManagementInterface;
use MageMastery\Blog\Model\PostFactory;
use MageMastery\Blog\Model\ResourceModel\Post as Postresource;

/**
 * Class PostManagement
 */
class PostManagement implements PostManagementInterface
{
    /**
     * @var PostFactory
     */
    private $postFactory;

    /**
     * @var Postresource
     */
    private $postResource;

    /**
     * @param PostFactory $postFactory
     * @param Postresource $postResource
     */
    public function __construct(PostFactory $postFactory, Postresource $postResource)
    {
        $this->postFactory = $postFactory;
        $this->postResource = $postResource;
    }

    /**
     * @return PostInterface
     */
    public function getEmptyObject(): PostInterface
    {
        return $this->postFactory->create();
    }


    /**
     * @param PostInterface $post
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function save(PostInterface $post)
    {
        $this->postResource->save($post);
    }
}
