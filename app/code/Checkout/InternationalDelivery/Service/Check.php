<?php

namespace Checkout\InternationalDelivery\Service;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Check
{
    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;
    /**
     * @var string
     */
    const XML_PATH_CARRIERS = 'carriers/';

    const XML_PATH_CARRIERS_TEST = 'carriers/internationaldelivery/enabled_counties';

    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @param null $storeId
     * @return mixed
     */
    public function getEnableC($storeId = null)
    {
        return $this->scopeConfig->getValue(self::XML_PATH_CARRIERS_TEST, $storeId);
    }
    /**
     * getConfigValue
     * @param mixed $field
     * @param null $storeId
     * @return mixed
     */
    public function getConfigValue($field, $storeId = null)
    {
        return $this->scopeConfig->getValue($field, ScopeInterface::SCOPE_STORE, $storeId);
    }

    /**
     * getGeneralConfig
     * @param mixed $code
     * @param null $storeId
     * @return mixed
     */
    public function getGeneralConfig($code, $storeId = null)
    {
        return $this->getConfigValue(self::XML_PATH_CARRIERS . 'internationaldelivery/' . $code, $storeId);
    }

    /**
     * getEnabledCounties
     * @return mixed
     */
    public function getEnabledCounties()
    {
        return $this->getGeneralConfig('enabled_counties');
    }
}
