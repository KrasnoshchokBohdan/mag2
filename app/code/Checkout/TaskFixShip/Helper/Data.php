<?php

namespace Checkout\TaskFixShip\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
{
    /**
     * @var string
     */
    const XML_PATH_CARRIERS = 'carriers/';

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
     * getGeneralConfig(S
     * @param mixed $code
     * @param null $storeId
     * @return mixed
     */
    public function getGeneralConfig($code, $storeId = null)
    {
        return $this->getConfigValue(self::XML_PATH_CARRIERS . 'taskfixship/' . $code, $storeId);
    }

    /**
     * getEnabledCounties
     * @return mixed
     */
    public function getEnabledCounties()
    {
        return $this->getGeneralConfig('enabled_counties');
    }

    /**
     * getEnabledCities
     * @return mixed
     */
    public function getEnabledCities()
    {
        return $this->getGeneralConfig('enabled_cities');
    }
}
