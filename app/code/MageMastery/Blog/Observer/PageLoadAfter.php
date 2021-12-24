<?php
declare(strict_types=1);
namespace MageMastery\Blog\Observer;

use MageMastery\Blog\Api\Data\PostInterface;
use MageMastery\Blog\Api\PostManagementInterface;
use MageMastery\Blog\Api\PostRepositoryInterface;
use MageMastery\Blog\Model\Post;
use MageMastery\Blog\Service\PostRepository;
use Magento\Cms\Api\Data\PageInterface;
use Magento\Cms\Model\Page;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;

/**
 * Class PageSaveAfter
 */
class PageLoadAfter implements ObserverInterface
{
    /**
     * @var PostRepositoryInterface
     */
    private $postRepository;

    /**
     * @param PostRepositoryInterface $postRepository
     */
    public function __construct(PostRepositoryInterface $postRepository){
        $this->postRepository = $postRepository;
    }
    /**
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        /**
         * @var PageInterface|Page $entity
         */
        $entity = $observer->getEvent()->getObject();
        $data = $entity->getData();


        /**
         * @var Post $post
         */
        $post = $this->postRepository->getByPageId($entity->getId());

        if ($post->getPageId()) {
            $entity->setData('author', $post->getData('author'));
            $entity->setData('is_post', $post->getData('is_post'));
            $entity->setData('publish_data', (new \DateTime($post->getData('publish_data')))->format('Y-m-d'));
            $entity->setData('page_id', $post->getData('page_id'));
        }
    }
}
