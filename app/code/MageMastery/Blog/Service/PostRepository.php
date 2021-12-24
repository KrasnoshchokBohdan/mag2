<?php

namespace MageMastery\Blog\Service;

use MageMastery\Blog\Api\Data\PostInterface;
use MageMastery\Blog\Api\PostManagementInterface;
use MageMastery\Blog\Api\PostRepositoryInterface;
use Magento\Cms\Api\PageRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;

use MageMastery\Blog\Model\ResourceModel\Post as PostResource;

/**
 * Class PostRepository
 */
class PostRepository implements PostRepositoryInterface
{
    private $pageRepository;

    private $searchCriteriaBuilder;

    /**
     * @var Post
     */
    private $resource;

    /**
     * @var PostManagementInterface
     */
    private $postManagement;

    /**
     * @param PageRepositoryInterface $pageRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param PostResource $resource
     * @param PostManagementInterface $postManagement
     */
    public function __construct(
        PageRepositoryInterface $pageRepository,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder,
        PostResource $resource,
        PostManagementInterface $postManagement
    ) {
        $this->pageRepository = $pageRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->resource = $resource;
        $this->postManagement = $postManagement;
    }

    public function get()
    {
        $searchCriteriaBuilder = $this->searchCriteriaBuilder->create();
        return $this->pageRepository->getList($searchCriteriaBuilder);
    }

    /**
     * @param int $pageId
     * @return PostInterface
     */
    public function getByPageId($pageId): PostInterface
    {
        $post = $this->postManagement->getEmptyObject();
        $this->resource->load($post, $pageId, 'page_id');

        return $post;
    }
}
