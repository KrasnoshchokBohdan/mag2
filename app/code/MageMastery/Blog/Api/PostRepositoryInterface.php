<?php

namespace MageMastery\Blog\Api;

use MageMastery\Blog\Api\Data\PostInterface;

interface PostRepositoryInterface
{
    /**
     * @return PostInterface
     */
    public function get();

    /**
     * @param int $pageId
     * @return PostInterface|Post
     */
    public function getByPageId($pageId): PostInterface;
}
