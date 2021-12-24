<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 * Php version 7.4
 * 
 * @category Some_Category
 * @package  Some_Package
 * @author   Display Name <someusername@example.com>
 * @license  some license
 * @link     some link
 */

namespace  WidgetJs\CloseInPrice\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

/**
 * Data
 * 
 * @category Some_Category
 * @package  Some_Package
 * @author   Display Name <someusername@example.com>
 * @license  some license
 * @link     some link
 * @api
 * @Some
 * @since    00.00.00
 */
class Data extends AbstractHelper
{
    /**
     * XML_PATH_CLOSEINPRICE
     * 
     * @var string
     */
    const XML_PATH_CLOSEINPRICE = 'closeinprice/';

    /**
     * Get general config value
     * 
     * @param mixed $field   field 
     * @param mixed $storeId storeId
     * 
     * @return mixed
     */
    public function getConfigValue($field, $storeId = null)
    {
        $scopeConfig = $this->scopeConfig;
        return $scopeConfig->getValue($field, ScopeInterface::SCOPE_STORE, $storeId);
    }

    /**
     * Get general config
     * 
     * @param mixed $code    code
     * @param mixed $storeId storeId
     * 
     * @return mixed
     */
    public function getGeneralConfig($code, $storeId = null)
    {
        return $this->getConfigValue(self::XML_PATH_CLOSEINPRICE.'general/'.$code, $storeId);
    }
}
