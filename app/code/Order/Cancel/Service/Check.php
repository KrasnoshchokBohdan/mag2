<?php

namespace Order\Cancel\Service;

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
    const XML_PATH_ORDER = 'cancel_order/';

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
    public function getSelectedStatus()
    {
        return $this->getGeneralConfig('status_list1');
    }

    /**
     * @return mixed
     */
    public function getSelectedGroup()
    {
        return $this->getGeneralConfig('group_list1');
    }
}
