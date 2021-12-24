<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Checkout\MyPay\Model;

/**
 * Custom payment method model
 *
 * @method \Magento\Quote\Api\Data\PaymentMethodExtensionInterface getExtensionAttributes()
 *
 * @api
 * @since 100.0.2
 */
class Mypay extends \Magento\Payment\Model\Method\AbstractMethod
{
    const MY_PAY_CODE = 'mypay';

    /**
     * Payment method code
     *
     * @var string
     */
    protected $_code = self::MY_PAY_CODE;

    /**
     * Custom payment block paths
     *
     * @var string
     */
    protected $_formBlockType = \Checkout\MyPay\Block\Form\Mypay::class;

    /**
     * Info instructions block path
     *
     * @var string
     */
    protected $_infoBlockType = \Magento\Payment\Block\Info\Instructions::class;

    /**
     * Availability option
     *
     * @var bool
     */
    protected $_isOffline = true;

    /**
     * Get instructions text from config
     *
     * @return string
     */
    public function getInstructions()
    {
        return trim($this->getConfigData('instructions'));
    }
}
