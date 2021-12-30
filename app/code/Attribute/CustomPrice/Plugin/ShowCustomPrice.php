<?php

namespace Attribute\CustomPrice\Plugin;

use Magento\Catalog\Model\Product;

class ShowCustomPrice
{
    /**
     * @var \Magento\Catalog\Block\Product\Context
     */
    private $context;


    public function __construct(
        \Magento\Catalog\Block\Product\Context $context
    ) {
        $this->context = $context;
    }

    /**
     * @param Product $subject
     * @param $result
     * @return mixed
     */
    public function afterGetPrice(Product $subject, $result)
    {
        if (!in_array('catalog_category_view', $this->context->getLayout()->getUpdate()->getHandles())) {
            return $result;
        } else {
            return $subject->getData('custom_price_attribute') ?? $result;
        }
    }
}
