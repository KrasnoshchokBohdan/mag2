<?php

namespace Learning\SocialAttribute\Block;

class Index extends \Magento\Framework\View\Element\Template
{
	protected $_registry;
	protected $helperData;

	public function __construct(
		\Learning\SocialAttribute\Helper\Data $helperData,
		\Magento\Backend\Block\Template\Context $context,
		\Magento\Framework\Registry $registry,
		array $data = []
	) {
		$this->helperData = $helperData;
		$this->_registry = $registry;
		parent::__construct($context, $data);
	}
	/** 
	 * 
	 * @return Magento\Catalog\Model\Product\Interceptor _eventObject: "product"
	 */
	public function getCurrentProduct()
	{
		if ($this->helperData->getGeneralConfig('enable')) {
			$currentProduct = $this->_registry->registry('current_product');
			return $currentProduct;
		}
	}

	/**
	 * 
	 * @return str
	 */
	public function getSocialPrice()
	{

		if ($this->helperData->getGeneralConfig('enable') && $this->getCurrentProduct()->getData('social_attribute')) {
			$socialPrice = $this->getCurrentProduct()->getFinalPrice() - ($this->getCurrentProduct()->getFinalPrice() / 100) * $this->helperData->getGeneralConfig('display_social');
			return 'Discount for a social product: ' . $this->helperData->getGeneralConfig('display_social') . '%<br /><hr />  Price including discount: $' . $socialPrice;
		}
	}
}
