<?php

namespace Perspective\TutorialProductPage\Block;


class Custom extends \Magento\Catalog\Block\Product\View
{
    /** @var \Mozok\Mymodule\Helper\Custom  */
    protected $_customHelper;

    public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
        \Magento\Framework\Url\EncoderInterface $urlEncoder,
        \Magento\Framework\Json\EncoderInterface $jsonEncoder,
        \Magento\Framework\Stdlib\StringUtils $string,
        \Magento\Catalog\Helper\Product $productHelper,
        \Magento\Catalog\Model\ProductTypes\ConfigInterface $productTypeConfig,
        \Magento\Framework\Locale\FormatInterface $localeFormat,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency,
        \Perspective\TutorialProductPage\Helper\Custom $customHelper,
        array $data = []
    ) {
        $this->_customHelper = $customHelper;
        parent::__construct(
            $context,
            $urlEncoder,
            $jsonEncoder,
            $string,
            $productHelper,
            $productTypeConfig,
            $localeFormat,
            $customerSession,
            $productRepository,
            $priceCurrency,
            $data);
    }

    /**
     * Get any value for our template
     *
     * @return string
     */
    public function getAnyCustomValue()
    {
        $currentProduct = $this->getProduct();
        $customValue = "Any Value : ";
        return $customValue . $currentProduct->getFinalPrice();
    }

    /**
     * @return bool
     */
    public function isAvailable()
    {
        $currentProduct = $this->getProduct();
        return $this->_customHelper->validateProductBySku($currentProduct->getSku());
    }
}
