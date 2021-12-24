<?php
namespace Perspective\ProductCollection\Block;
class Index extends \Magento\Framework\View\Element\Template
{
	protected $_collection;
	protected $_productRepository;
	
		
	public function __construct(
		\Magento\Backend\Block\Template\Context $context,		
		\Magento\Catalog\Model\ProductRepository $productRepository,
		array $data = []
	)
	{
			
		$this->_productRepository = $productRepository;
		parent::__construct($context, $data);
	}
	public function getHello()
	{
		return "hello";
	}
	public function getProductCollection()
	{
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $productCollectionFactory = $objectManager->get('\Magento\Catalog\Model\ResourceModel\Product\CollectionFactory');
        return $this->_collection = $productCollectionFactory->create();
	}
}


