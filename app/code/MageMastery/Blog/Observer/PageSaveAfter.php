<?php
declare(strict_types=1);
namespace MageMastery\Blog\Observer;

use MageMastery\Blog\Api\Data\PostInterface;
use MageMastery\Blog\Api\PostManagementInterface;
use Magento\Cms\Api\Data\PageInterface;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;

/**
 * Class PageSaveAfter
 */
class PageSaveAfter implements ObserverInterface
{
    /**
     * @var PostManagementInterface
     */
    private $postManagement;

    /**
     * @param PostManagementInterface $postManagement
     */
    public function __construct(PostManagementInterface $postManagement){
        $this->postManagement = $postManagement;
    }
    /**
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        /**
         * @var PageInterface $entity
         */
        $entity = $observer->getEvent()->getObject();
        $data = $entity->getData();

        /** @var PostInterface|Post $post*/
        $post = $this->postManagement->getEmptyObject();
        $post->setData('author', $data['author']);
        $post->setData('is_post', $data['is_post']);
        $post->setData('publish_data', (new \DateTime($data['publish_data']))->format('Y-m-d H:i:s'));
        $post->setData('page_id', $data['page_id']);

        $this->postManagement->save($post);
    }
}
