<?php

namespace Checkout\Wholesale\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
{
    /**
     * @var string
     */
    const XML_PATH_WHOLESALE = 'wholesale/';

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
         return $this->getConfigValue(self::XML_PATH_WHOLESALE . 'general/' . $code, $storeId);
    }

    /**
     * getLargeWholesaleConfig
     * @param mixed $code
     * @param null $storeId
     * @return mixed
     */
    public function getLargeWholesaleConfig($code, $storeId = null)
    {
        return $this->getConfigValue(self::XML_PATH_WHOLESALE . 'large_wholesale/' . $code, $storeId);
    }

    /**
     * getWholesaleConfig
     * @param mixed $code
     * @param null $storeId
     * @return mixed
     */
    public function getWholesaleConfig($code, $storeId = null)
    {
        return $this->getConfigValue(self::XML_PATH_WHOLESALE . 'wholesale/' . $code, $storeId);
    }

    /**
     * getModuleEnabled
     * @return mixed
     */
    public function getModuleEnabled()
    {
        return $this->getGeneralConfig('enable');
    }

    /**
     * getEnabledLargeWholesale
     * @return mixed
     */
    public function getEnabledLargeWholesale()
    {
        return $this->getLargeWholesaleConfig('enabled_large_wholesale');
    }

    /**
     * getEnabledWholesale
     * @return mixed
     */
    public function getEnabledWholesale()
    {
        return $this->getWholesaleConfig('enabled_wholesale');
    }
}
