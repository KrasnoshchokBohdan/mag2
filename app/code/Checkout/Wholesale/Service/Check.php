<?php

namespace Checkout\Wholesale\Service;

use Magento\Checkout\Model\Session as Checkout;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Checkout\Wholesale\Helper\Data;

class Check
{
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
     */

    public function __construct(
        Data $helperData,
        Checkout $checkoutSession
    ) {
        $this->helperData = $helperData;
        $this->checkoutSession = $checkoutSession;
    }

    /**
     * @return bool
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function checkWholesale(): bool
    {
        if (!$this->helperData->getEnabledWholesale()) {
            return false;
        }
        $customerGroupId = $this->checkoutSession->getQuote()->getCustomerGroupId();
        $asLargeWholesale = $this->helperData->getWholesaleConfig('group_list1');
        if ($customerGroupId == $asLargeWholesale) {
            return true;
        }
        return false;
    }

    /**
     * @return bool
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function checkLargeWholesale(): bool
    {
        if (!$this->helperData->getEnabledLargeWholesale()) {
            return false;
        }
        $customerGroupId = $this->checkoutSession->getQuote()->getCustomerGroupId();
        $asLargeWholesale = $this->helperData->getLargeWholesaleConfig('group_list');
        if ($customerGroupId == $asLargeWholesale) {
            return true;
        }
        return false;
    }
}
