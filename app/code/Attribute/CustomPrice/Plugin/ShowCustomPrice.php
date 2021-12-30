<?php

namespace Attribute\CustomPrice\Plugin;

use Magento\Catalog\Model\Product;
use Attribute\CustomPrice\Service\Check;

class ShowCustomPrice
{
    /**
     * @var \Magento\Catalog\Block\Product\Context
     */
    private $context;
    /**
     * @var Check
     */
    private $data;

    public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
        Check                $data
    ) {
        $this->context = $context;
        $this->data = $data;
    }

    /**
     * @param Product $subject
     * @param $result
     * @return mixed
     */
    public function afterGetPrice(Product $subject, $result)
    {
        if (!$this->data->getModuleEnabled()) {
            return $result;
        }

        if (!in_array('catalog_category_view', $this->context->getLayout()->getUpdate()->getHandles())) {
            return $result;
        } else {
            $result = $subject->getData('custom_price_attribute');
            return $result;
        }
    }
}
