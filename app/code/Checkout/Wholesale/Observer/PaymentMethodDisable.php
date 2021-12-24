<?php

namespace Checkout\Wholesale\Observer;

use Magento\Checkout\Model\Session as Checkout;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Checkout\Wholesale\Helper\Data;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Checkout\Wholesale\Service\Check;

class PaymentMethodDisable implements ObserverInterface
{
    /**
     * @var Check;
     */
    protected $check;
    /**
     * @var Checkout
     */
    protected $checkoutSession;
    /**
     * @var Data
     */
    protected $helperData;

    /**
     * @param Data $helperData
     * @param Checkout $checkoutSession
     * @param Check $check
     */
    public function __construct(
        Data $helperData,
        Checkout       $checkoutSession,
        Check $check
    ) {
        $this->helperData = $helperData;
        $this->checkoutSession = $checkoutSession;
        $this->check = $check;
    }

    /**
     * @param Observer $observer
     * @return void
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function execute(Observer $observer)
    {
        $paymentMethodCode = $observer->getEvent()->getMethodInstance()->getCode();
        $orderSum = $this->checkoutSession->getQuote()->getGrandTotal();
        $checkoutQty = $this->checkoutSession->getQuote()->getItemsQty();
        $result = $observer->getEvent()->getResult();

        if ($this->helperData->getModuleEnabled()) {
            return;
        }

        if ($this->check->checkLargeWholesale()) {
            $selectedPayMethod = $this->helperData->getLargeWholesaleConfig('pay_list');
            if ($paymentMethodCode !== $selectedPayMethod) {
                $selectedOrderSum = $this->helperData->getLargeWholesaleConfig('summ');
                if ($orderSum > $selectedOrderSum) {
                    $result->setData('is_available', false);
                }
            }
        }

        if ($this->check->checkWholesale()) {
             $selectedPayMethod = $this->helperData->getWholesaleConfig('pay_list1');
            if ($paymentMethodCode !== $selectedPayMethod) {
                $adminQty = $this->helperData->getWholesaleConfig('qty');
                if ($checkoutQty > $adminQty) {
                    $result->setData('is_available', false);
                }
            }
        }
    }
}
