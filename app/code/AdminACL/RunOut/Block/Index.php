<?php

namespace AdminACL\RunOut\Block;

class Index extends \Magento\Framework\View\Element\Template
{
	protected $_registry;
	protected $helperData;
	protected $_stockItemRepository;

	public function __construct(
		\AdminACL\RunOut\Helper\CustomData $helperData,
		\Magento\Backend\Block\Template\Context $context,
		\Magento\CatalogInventory\Model\Stock\StockItemRepository $stockItemRepository,
		\Magento\Framework\Registry $registry,
		array $data = []
	) {


		$this->helperData = $helperData;
		$this->_registry = $registry;
		$this->_stockItemRepository = $stockItemRepository;
		parent::__construct($context, $data);
	}
	/**
	 * 
	 * @return current_product  
	 */
	public function getCurrentProduct()
	{
		if ($this->helperData->getGeneralConfig('enable')) {
			return $this->_registry->registry('current_product');
		}
		return null;
	}

	/**
	 * 
	 * @return str
	 */
	public function getQuantityMessage()
	{
		$currentProd = $this->getCurrentProduct()->getEntityId();
		$prodQty = $this->_stockItemRepository->get($currentProd);

		return $prodQty->getQty() . ' units left';
	}

	/**
	 * 
	 * @return str
	 */
	public function getRunOut()
	{
		$currentProd = $this->getCurrentProduct()->getEntityId();
		$prodQty = $this->_stockItemRepository->get($currentProd);
		$Qty = $prodQty->getQty();

		if ($this->helperData->getGeneralConfig('display_qty') > $Qty)
			return 'Заканчивается';
	}
}
