<?php
namespace Checkout\MyPay\Block\Form;

/**
 * Block for Custom payment method form
 */
class Mypay extends \Magento\OfflinePayments\Block\Form\AbstractInstruction
{
    /**
     * Custom payment template
     *
     * @var string
     */
    protected $_template = 'Checkout_MyPay::form/mypay.phtml';
}

