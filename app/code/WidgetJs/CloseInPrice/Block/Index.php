<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 * Php version 7.4
 *
 * @category Some_Category
 * @package  Some_Package
 * @author   Display Name <someusername@example.com>
 * @license  some license
 * @link     some link
 */

namespace WidgetJs\CloseInPrice\Block;

/**
 *  Short description
 *
 * @category   Some_Category
 * @package    Some_Package
 * @author     Display Name <someusername@example.com>
 * @license    some license
 * @link       some link
 * @since      00.00.00
 * @deprecated Some_deprecated
 * @api
 */
class Index extends \Magento\Framework\View\Element\Template
{
    /**
     * Registry collection
     *
     * @var object
     */
    protected $registry;
    /**
     * Helper
     *
     * @var object
     */
    protected $helperData;
    /**
     * CollectionFactory
     *
     * @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory
     */
    protected $productCollectionFactory;
    /**
     * ImageHelper
     *
     * @var \Magento\Catalog\Helper\Image
     */
    protected $productImageHelper;
    /**
     * Resolver
     *
     * @var \Magento\Catalog\Model\Layer\Resolver
     */
    private $_layerResolver;

    /**
     * Index constructor
     *
     * @param \Magento\Backend\Block\Template\Context $context context
     * @param \Magento\Framework\Registry $registry registry
     * @param \WidgetJs\CloseInPrice\Helper\Data $helperData helperData
     * @param \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory productCollectionFactory
     * @param \Magento\Catalog\Helper\Image $productImageHelper productImageHelper
     * @param \Magento\Catalog\Model\Layer\Resolver $layerResolver layerResolver
     * @param array<Type> $data data
     *
     * @some(some)
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context                        $context,
        \Magento\Framework\Registry                                    $registry,
        \WidgetJs\CloseInPrice\Helper\Data                             $helperData,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \Magento\Catalog\Helper\Image                                  $productImageHelper,
        \Magento\Catalog\Model\Layer\Resolver                          $layerResolver,
        array                                                          $data = []
    )
    {
        $this->registry = $registry;
        $this->helperData = $helperData;
        $this->productCollectionFactory = $productCollectionFactory;
        $this->productImageHelper = $productImageHelper;
        $this->_layerResolver = $layerResolver;
        parent::__construct($context, $data);
    }

    /**
     * Get current product
     *
     * @return Object
     */
    public function getCurrentProduct()
    {
        $currentProduct = $this->registry->registry('current_product');
        return $currentProduct;
    }

    /**
     * Get Price Difference from Admin ACL
     *
     * @return mixed
     */
    public function getPriceDifference()
    {
        if ($this->helperData->getGeneralConfig('enable')) {
            if ($this->helperData->getGeneralConfig('price_difference')) {
                return $this->helperData->getGeneralConfig('price_difference');
            }
            return null;
        }
        return null;
    }

    /**
     * Get cutegory id for current product
     *
     * @return mixed
     */
    public function getCurrentCategoryId()
    {
        if ($this->helperData->getGeneralConfig('enable')) {
            $max = 0;
            $categoryIds = $this->getCurrentProduct()->getCategoryIds();
            foreach ($categoryIds as $elem) {
                if ($elem > $max) {
                    $max = $elem;
                }
            }
            return $max;
        }
        return null;
    }

    /**
     * Get current category id by Registry
     *
     * @return mixed
     */
    public function getCurrentCategoryIdRegistry()
    {
        if ($this->helperData->getGeneralConfig('enable')) {
            $category = $this->registry->registry('current_category');
            $categoryId = $category ? $category->getId() : null;
            if ($categoryId) {
                return $categoryId;
            }
            return "-";
        }
        return null;
    }

    /**
     * Get current category id by layerResolver
     *
     * @return mixed
     */
    public function getCurrentCategoryIdResolver()
    {
        if ($this->helperData->getGeneralConfig('enable')) {
            $catalogLayer = $this->_layerResolver->get();
            $categoryId = $catalogLayer->getCurrentCategory()->getId();;
            if ($categoryId) {
                return $categoryId;
            }
            return '-';
        }
        return null;
    }

    /**
     * Get product collection by category id
     *
     * @return iterable<Type>
     */
    public function getProductCollectionByCategories()
    {
        $collection = $this->productCollectionFactory->create();
        $id = $this->getCurrentCategoryId();
        $collection->addAttributeToSelect('*');
        $collection->addCategoriesFilter(['in' => $id]);
        return $collection;
    }

    /**
     * Get products by price difference
     *
     * @return iterable<Type>|array
     */
    public function getProductsByPriceDifference()
    {
        $collectionByCat = $this->getProductCollectionByCategories();
        $data = [];
        foreach ($collectionByCat as $product) {
            $getPriceInfo = $product->getPriceInfo();
            $prodPrice = $getPriceInfo->getPrice('final_price')->getValue();
            $currentProduct = $this->getCurrentProduct();
            $getPriceInfo = $currentProduct->getPriceInfo();
            $curProductPrice = $getPriceInfo->getPrice('final_price')->getValue();
            $priceDif = $this->getPriceDifference();
            $prodMinus = $prodPrice - $curProductPrice;
            $currentProdMinus = $curProductPrice - $prodPrice;
            if ($prodMinus < $priceDif || $currentProdMinus > -$priceDif) {
                $data[] = $product;
            }
        }
        return $data;
    }

    /**
     * Get product image url
     *
     * @param \Magento\Catalog\Model\Product $product product
     * @param string $imageId imageId
     * @param Type[] $attributes attributes
     *
     * @return string
     */
    public function getProductImageUrl($product, $imageId, $attributes = [])
    {
        $productImageHelper = $this->productImageHelper;
        return $productImageHelper->init($product, $imageId, $attributes)->getUrl();
    }

    /**
     * Get product image url array
     *
     * @return mixed
     */
    public function getProductImageUrlArray()
    {
        $categoryProducts = $this->getProductsByPriceDifference();
        $arr = [];
        foreach ($categoryProducts as $product) {
            $prodId = $product->getData('entity_id');
            $currentProdId = $this->getCurrentProduct()->getData('entity_id');
            if ($prodId !== $currentProdId) {
                $url = $this->getProductImageUrl($product, 'product_small_image');
                $arr[] = $url;
            }
        }
        if ($arr) {
            return $arr;
        }
        return null;
    }

    /**
     * Get product image url array str
     *
     * @return mixed
     */
    public function getProductImageUrlArrayStr()
    {
        if ($this->helperData->getGeneralConfig('enable')) {
            $arr = $this->getProductImageUrlArray();
            $imgArr = '';
            foreach ($arr as $elem) {
                $imgArr .= "{ img: '{$elem}' },";
            }
            if ($imgArr) {
                return trim($imgArr, ',');
            }
            return null;
        }
        return null;
    }
}
