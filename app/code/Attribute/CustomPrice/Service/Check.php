<?php

namespace Attribute\CustomPrice\Service;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Check
{
    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * const XML_PATH_CUSTOM_PATH
     */
    const XML_PATH_CUSTOM_PATH = 'attribute_custom_price_section_id/attribute_price_group_id/';

    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @param $field
     * @param $storeId
     * @return mixed
     */
    public function getConfigValue($field, $storeId = null)
    {
        return $this->scopeConfig->getValue(
            $field,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * @return mixed
     */
    public function getModuleEnabled()
    {
        return $this->getConfigValue(self::XML_PATH_CUSTOM_PATH.'enable_custom_price');
    }

    /**
     * @return mixed
     */
    public function getDiscountCustomPrice()
    {
        return $this->getConfigValue(self::XML_PATH_CUSTOM_PATH.'custom_price_discount');
    }
}
