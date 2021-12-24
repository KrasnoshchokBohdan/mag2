<?php
namespace Perspective\TaskBd\Block;

class Index extends \Magento\Framework\View\Element\Template
{
    protected $postCollectionFactory;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Perspective\TaskBd\Model\ResourceModel\Post\CollectionFactory $postCollectionFactory,
        array $data = []
    ) {
        $this->postCollectionFactory = $postCollectionFactory;
        parent::__construct($context, $data);
    }
     /**
       * 
       * @return \Perspective\TaskBd\Model\ResourceModel\Post\Collection;
       *  */

    public function getPostCollection() {
        $post = $this->postCollectionFactory->create();
        $post->addFieldToSelect('*');
        return $post; 
    }
     /**
       * 111
       * @return \Perspective\TaskBd\Model\ResourceModel\Post\Collection;
       *  */
    public function getPostCollectionForTwoCategories() {
        $post = $this->postCollectionFactory->create();
        $post->addFieldToSelect('*')->addFieldToFilter('IDCat',['in'=>[4,14]]);
        return $post;
    }
         /**
       * 222
       * @return \Perspective\TaskBd\Model\ResourceModel\Post\Collection;
       *  */
      public function getPostCollectionForProduct() {
        $post = $this->postCollectionFactory->create();
        $post->addFieldToSelect('*')->addFieldToFilter('IDProd',['eq'=>12]);
        return $post;
    }


}