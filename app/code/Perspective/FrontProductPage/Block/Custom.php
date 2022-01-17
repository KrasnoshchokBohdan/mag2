<?php

namespace Perspective\FrontProductPage\Block;


class Custom extends \Magento\Framework\View\Element\Template
{
    protected $_registry;
    protected $_stockItemRepository;


    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\CatalogInventory\Model\Stock\StockItemRepository $stockItemRepository,
        \Magento\Framework\Registry $registry,
        array $data = []
        )
        {
            $this->_stockItemRepository = $stockItemRepository;
            $this->_registry = $registry;
            parent::__construct($context, $data);
    }




    public function getCurrentProduct()
    {
        return  $this->_registry->registry('current_product');
    }

	public function getStockItem($productId)
		{
			return $this->_stockItemRepository->get($productId);
		}
}

