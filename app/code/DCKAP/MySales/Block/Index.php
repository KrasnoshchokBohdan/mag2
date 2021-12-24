<?php
namespace DCKAP\MySales\Block;

class Index extends \Magento\Framework\View\Element\Template
{
    protected $postCollectionFactory;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \DCKAP\MySales\Model\ResourceModel\Data\CollectionFactory $postCollectionFactory,
        array $data = []
    ) {
        $this->postCollectionFactory = $postCollectionFactory;
        parent::__construct($context, $data);
    }
     /**
       * 
       * @return \DCKAP\MySales\Model\ResourceModel\Data\Collection;
       *  */
    public function getCollection() {
        $post = $this->postCollectionFactory->create();
        $post->addFieldToSelect('*');
        return $post; 
    }
    /**
       * 
       * @return \DCKAP\MySales\Model\ResourceModel\Data\Collection;
       *  */
    public function getCollectionByName() {
        $post = $this->postCollectionFactory->create();
        $post->addFieldToSelect('*')->addFieldToFilter('Product_name',['eq'=>'Product2']);
        return $post; 
    }

}