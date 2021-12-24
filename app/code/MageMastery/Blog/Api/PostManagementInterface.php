<?php

namespace MageMastery\Blog\Api;


use MageMastery\Blog\Api\Data\PostInterface;

/**
 * Interface PostManagementInterface
 * @api
 */
interface PostManagementInterface
{
    /**
     * @return PostInterface
     */
    public function getEmptyObject();

    /**
     * @param PostInterface $post
     * @return void
     */
    public function save(PostInterface $post);
}
