<?php

namespace Learning\Currency\Block;

use Dotdigitalgroup\Email\Block\Adminhtml\Config\Report\Catalog;
use Learning\Currency\Helper\Data;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\View\Element\Template;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\Session as CatalogSession;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class CatalogPrice extends Template
{

    /**
     * @var CatalogSession
     */
    private $catalogSession;

    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * Current Product
     *
     * @var ProductInterface
     */
    private $currentProduct;

    private $helperData;

    /**
     * @return ProductInterface
     * @throws NoSuchEntityException
     */

    /**
     * @param CatalogSession $catalogSession
     * @param ProductRepositoryInterface $productRepository
     * @param Data $helperData
     */
    public function __construct (
        Context $context,
        Data $helperData,
        CatalogSession $catalogSession,
        ProductRepositoryInterface $productRepository,
        array $data = []
    ) {
        $this->catalogSession = $catalogSession;
        $this->productRepository = $productRepository;
        $this->helperData = $helperData;
        parent::__construct($context, $data);
    }

    protected static $_instance;

    /**
     * Retrieve object manager
     *
     * @return CatalogPrice
     */
    public static function getInstance()
    {
        return self::$_instance;
    }

    public function getProduct(): ProductInterface
    {
        if (!isset($this->currentProduct)) {
            $productId = $this->getProductId();

            if ($productId) {
                $this->currentProduct = $this->productRepository->getById($productId);
            }
        }
        return $this->currentProduct;
    }

    /**
     * @return string
     */
    public function getProductId(): string
    {
        return $this->catalogSession->getData('last_viewed_product_id');
    }

    public function checkEnableModule() {
        return $this->helperData->getGeneralConfig('enable');
    }

    public function getUahExchange() {
        $enabled = $this->helperData->getGeneralConfig('uah_enable');
        $exRate = $this->helperData->getGeneralConfig('uah_ex_rate');
        if ($enabled != 0 and $exRate !== null) {
            $productId = $this->getProductId();
            $product = $this->getProduct($productId);
            $productPrice = $product->getPrice();
            return round($productPrice*$exRate, 2);
        } else {
            return null;
        }
    }

    public function getRubExchange() {
        $enabled = $this->helperData->getGeneralConfig('rub_enable');
        $exRate = $this->helperData->getGeneralConfig('rub_ex_rate');
        if ($enabled != 0 and $exRate !== null) {
            $productId = $this->getProductId();
            $product = $this->getProduct($productId);
            $productPrice = $product->getPrice();
            return round($productPrice*$exRate, 2);
        } else {
            return null;
        }
    }

    public function getEuroExchange() {
        $enabled = $this->helperData->getGeneralConfig('euro_enable');
        $exRate = $this->helperData->getGeneralConfig('euro_ex_rate');
        if ($enabled != 0 and $exRate !== null) {
            $productId = $this->getProductId();
            $product = $this->getProduct($productId);
            $productPrice = $product->getPrice();
            return round($productPrice*$exRate, 2);
        } else {
            return null;
        }
    }
}
