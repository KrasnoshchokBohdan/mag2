<?php

namespace TestTasks\TaskTwo\Block;

class Index extends \Magento\Framework\View\Element\Template
{
	protected $_registry;
	protected $helperData;

	public function __construct(
		\TestTasks\TaskTwo\Helper\Data $helperData,
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
	 * @return string
	 */
	public function getBasePrice()
	{
		if ($this->helperData->getGeneralConfig('enable')) {
			if ($this->getCurrentProduct()) {
				if ($selectValue = $this->helperData->getGeneralConfig('base_price')) {
					if ($this->getCurrentProduct()->getTypeId() == 'configurable') {
						//	$basePrice = $this->getCurrentProduct()->getPriceInfo()->getPrice('base_price')->getValue();
						$basePrice = $this->getCurrentProduct()->getPriceInfo()->getPrice('regular_price')->getMinRegularAmount()->getValue();
						return 'Base price: ' . $basePrice;
					} elseif ($this->getCurrentProduct()->getTypeId() == 'simple') {
						//	$basePrice = $this->getCurrentProduct()->getPriceInfo()->getPrice('base_price')->getValue();
						$basePrice = $this->getCurrentProduct()->getPriceInfo()->getPrice('regular_price')->getValue();
						return 'Base price: ' . $basePrice;
					} else {
						return null;
					}
				}
			}
		}
	}

	/**
	 * 
	 * @return string
	 */
	public function getFinalPrice()
	{
		if ($this->helperData->getGeneralConfig('enable')) {
			if ($this->getCurrentProduct()) {
				if ($selectValue = $this->helperData->getGeneralConfig('final_price')) {
					if ($this->getCurrentProduct()->getTypeId() == 'configurable') {
						$finalPrice = $this->getCurrentProduct()->getPriceInfo()->getPrice('final_price')->getMinimalPrice()->getValue();
						return 'Final price: ' . $finalPrice;
					} elseif ($this->getCurrentProduct()->getTypeId() == 'simple') {
						$finalPrice = $this->getCurrentProduct()->getPriceInfo()->getPrice('final_price')->getValue();
						return 'Final price: ' . $finalPrice;
					} else {
						return null;
					}
				}
			}
		}
	}

	/**
	 * 
	 * @return string
	 */
	public function getSpecialPrice()
	{
		if ($this->helperData->getGeneralConfig('enable')) {
			if ($this->getCurrentProduct()) {
				if ($selectValue = $this->helperData->getGeneralConfig('special_price')) {
					if ($this->getCurrentProduct()->getTypeId() == 'configurable' || $this->getCurrentProduct()->getTypeId() == 'simple') {
						$specialPrice = $this->getCurrentProduct()->getPriceInfo()->getPrice('special_price')->getValue();
						return 'Special price: ' . $specialPrice;
					} else {
						return null;
					}
				}
			}
		}
	}

	/**
	 * 
	 * @return string
	 */
	public function getTierPrice()
	{
		if ($this->helperData->getGeneralConfig('enable')) {
			if ($this->getCurrentProduct()) {
				if ($selectValue = $this->helperData->getGeneralConfig('tier_price')) {
					if ($this->getCurrentProduct()->getTypeId() == 'configurable' || $this->getCurrentProduct()->getTypeId() == 'simple') {
						$tierPrice = $this->getCurrentProduct()->getPriceInfo()->getPrice('tier_price')->getValue();
						return 'Tier price: ' . $tierPrice;
					} else {
						return null;
					}
				}
			}
		}
	}

	/**
	 * 
	 * @return string
	 */
	public function getRulePrice()
	{
		if ($this->helperData->getGeneralConfig('enable')) {
			if ($this->getCurrentProduct()) {
				if ($selectValue = $this->helperData->getGeneralConfig('catalog_rule_price')) {
					if ($this->getCurrentProduct()->getTypeId() == 'configurable' || $this->getCurrentProduct()->getTypeId() == 'simple') {
						$rulePrice = $this->getCurrentProduct()->getPriceInfo()->getPrice('catalog_rule_price')->getValue();
						return 'Catalog rule price: ' . $rulePrice;
					} else {
						return null;
					}
				}
			}
		}
	}
}
