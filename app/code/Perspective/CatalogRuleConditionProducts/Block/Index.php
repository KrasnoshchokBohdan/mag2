<?php
namespace Perspective\CatalogRuleConditionProducts\Block;
class Index extends \Magento\Framework\View\Element\Template
{
	protected $_productRepository;
	
	   /** @var \Magento\CatalogRule\Model\ResourceModel\Rule\CollectionFactory  */
	   protected $_ruleCollectionFactory;
		   /** @var \Magento\Store\Model\StoreManagerInterface  */
	   protected $_storeManager;
		
	public function __construct(
	   \Magento\CatalogRule\Model\ResourceModel\Rule\CollectionFactory $ruleCollectionFactory,
	   \Magento\Store\Model\StoreManagerInterface $storeManager,
		\Magento\Backend\Block\Template\Context $context,		
		\Magento\Catalog\Model\ProductRepository $productRepository,
		array $data = []
	)
	{   $this->_ruleCollectionFactory = $ruleCollectionFactory;
		$this->_storeManager = $storeManager;
		$this->_productRepository = $productRepository;
		parent::__construct($context, $data);
	}

	public function getProductById($id)
	{
		return $this->_productRepository->getById($id);
	}

	public function getCatalogPriceRuleProductIds()
	{
     	$websiteId = $this->_storeManager->getStore()->getWebsiteId();//current Website Id
	
		$resultProductIds = [];
		$catalogRuleCollection = $this->_ruleCollectionFactory->create();
		$catalogRuleCollection->addIsActiveFilter(1);//filter for active rules only
		foreach ($catalogRuleCollection as $catalogRule) {
			$productIdsAccToRule = $catalogRule->getMatchingProductIds();
			foreach ($productIdsAccToRule as $productId => $ruleProductArray) {
				if (!empty($ruleProductArray[$websiteId])) {
					$resultProductIds[$productId] = $catalogRule->getName();//name of rule
				}
			}
		}
		return $resultProductIds;
	}
}


 