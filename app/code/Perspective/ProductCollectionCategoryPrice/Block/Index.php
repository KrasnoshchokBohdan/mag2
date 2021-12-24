<?php
namespace Perspective\ProductCollectionCategoryPrice\Block;
class Index extends \Magento\Framework\View\Element\Template
{
     /**
     * @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory
     */
    protected $_productCollectionFactory;
  
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,        
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory
    )
    {    
        $this->_productCollectionFactory = $productCollectionFactory;
        parent::__construct($context);
    }
    
    /**
     * 
     * @param array $ids 
     * @return \Magento\Catalog\Model\ResourceModel\Product\Collection
     */
    public function getProductCollectionByCategories(array $ids)
    {
        $collection = $this->_productCollectionFactory->create();
        $collection->addAttributeToSelect('*');
        $collection->addCategoriesFilter(['in' => $ids]);
        return $collection;
    }
}


