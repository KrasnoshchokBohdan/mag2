<?php
namespace Perspective\ProductCollectionFilterVisibility\Block;
class Index extends \Magento\Framework\View\Element\Template
{
    protected $productCollectionFactory;
    protected $productVisibility;
    protected $productStatus;
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,        
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \Magento\Catalog\Model\Product\Attribute\Source\Status $productStatus,
        \Magento\Catalog\Model\Product\Visibility $productVisibility,
        array $data = []
    )
    {
        $this->productCollectionFactory = $productCollectionFactory;
        $this->productStatus = $productStatus;
        $this->productVisibility = $productVisibility;
        parent::__construct($context, $data);
    }
    public function getProductCollection()
    {
        $collection = $this->productCollectionFactory->create();
        $collection->addAttributeToFilter('status', ['in' => $this->productStatus->getVisibleStatusIds()]);
        $collection->setVisibility($this->productVisibility->getVisibleInSiteIds());
        return $collection;
    }
}
