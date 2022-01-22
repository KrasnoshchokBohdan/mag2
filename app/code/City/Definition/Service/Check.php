<?php

namespace City\Definition\Service;

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
    const XML_PATH_ORDER = 'city_definition/';

    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
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
        return $this->getConfigValue(self::XML_PATH_ORDER . 'general/' . $code, $storeId);
    }

    /**
     * @return mixed
     */
    public function getEnabledModule()
    {
        return $this->getGeneralConfig('enable');
    }

    /**
     * @return mixed
     */
    public function getIpStackKey()
    {
        return $this->getGeneralConfig('ipstack_access_key');
    }

    /**
     * @return mixed
     */
    public function getNpKey()
    {
        return $this->getGeneralConfig('np_access_key');
    }
}
