<?php

namespace Checkout\Wholesale\Plugin;

use Checkout\Wholesale\Service\Check;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Quote\Model\Quote\Address\RateResult\AbstractResult;
use Magento\Shipping\Model\Rate\Result;
use Checkout\Wholesale\Helper\Data;
use Magento\Checkout\Model\Session as Checkout;

class ShippingMethodsDisable
{
    /**
     * @var Check;
     */
    protected $check;

    /**
     * @var Data
     */
    protected $helperData;
    /**
     * @var Checkout
     */
    protected $checkoutSession;

    /**
     * PaymentMethodAvailable constructor.
     * @param Data $helperData
     * @param Checkout $checkoutSession
     * @param Check $check
     */
    public function __construct(
        Data     $helperData,
        Checkout $checkoutSession,
        Check    $check
    )
    {
        $this->helperData = $helperData;
        $this->checkoutSession = $checkoutSession;
        $this->check = $check;
    }

    /**
     * @param Result $subject
     * @param AbstractResult|Result $result
     * @return false|array
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function beforeAppend(Result $subject, $result)
    {
        if (!$this->helperData->getModuleEnabled()) {
            return [$result];
        }

        if ($this->check->checkLargeWholesale()) {
            if ($result instanceof AbstractResult) {
                if ($result->getData('carrier') === 'freeshipping') {
                    return [$result];
                } else {
                    return false;
                }
            }
            return [$result];
        }

        if ($this->check->checkWholesale()) {
            $checkoutQty = $this->checkoutSession->getQuote()->getItemsQty();
            $adminQty = $this->helperData->getWholesaleConfig('qty');
            if ($checkoutQty > $adminQty) {
                if ($result instanceof AbstractResult) {
                    $carrierWholesale = $this->helperData->getWholesaleConfig('del_list');
                    if ($result->getData('carrier') === $carrierWholesale) {
                        return [$result];
                    } else {
                        return false;
                    }
                }
            }

            if ($result instanceof AbstractResult) {
                if ($result->getData('carrier') === 'freeshipping') {
                    return false;
                } else {
                    return [$result];
                }
            }
        }
        return [$result];
    }
}
