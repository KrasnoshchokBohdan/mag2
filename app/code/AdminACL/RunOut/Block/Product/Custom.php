<?php

namespace AdminACL\RunOut\Block\Product;

use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Catalog\Block\Product\Context;
use Magento\Catalog\Block\Product\ListProduct;
use Magento\Catalog\Model\Layer\Resolver;
use Magento\CatalogInventory\Model\Stock\StockItemRepository;
use Magento\Framework\Data\Helper\PostHelper;
use Magento\Framework\Url\Helper\Data;
use Magento\Catalog\Api\ProductRepositoryInterface;
use AdminACL\RunOut\Helper\CustomData;



class Custom extends ListProduct
{
    protected $_productRepository;

    protected $helper;
    /**
     * @var StockItemRepository
     */
    protected $_stockItemRepository;
    /**
     * @var ProductRepositoryInterface
     */

    /**
     * Custom constructor.
     * @param CustomData $helper
     * @param Data $urlHelper
     * @param Context $context
     * @param PostHelper $postDataHelper
     * @param Resolver $layerResolver
     * @param CategoryRepositoryInterface $categoryRepository
     * @param ProductRepositoryInterface $productRepository
     * @param StockItemRepository $stockItemRepository
     * @param array $data
     */
    public function __construct(
        CustomData $helper,
        Data $urlHelper,
        Context $context,
        PostHelper $postDataHelper,
        Resolver $layerResolver,
        CategoryRepositoryInterface $categoryRepository,
        ProductRepositoryInterface $productRepository,
        StockItemRepository $stockItemRepository,
        array $data = []
    ) {
        $this->helper = $helper;
        $this->_stockItemRepository = $stockItemRepository;
        $this->_productRepository = $productRepository;

        parent::__construct($context, $postDataHelper, $layerResolver, $categoryRepository, $urlHelper, $data);
    }

    /**
     * 
     * @return str
     */
    public function getRunOut($_product)
    {
        $qty = $this->_stockItemRepository->get($_product->getId())->getQty();


        if ($this->helper->getGeneralConfig('display_qty') > $qty)
            return '<b>RUN OUT!</b>';
    }
}
