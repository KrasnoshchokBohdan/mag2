<?php

namespace Checkout\InternationalDelivery\Observer;

use Magento\Checkout\Model\Session as Checkout;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Checkout\InternationalDelivery\Service\Check;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

class PaymentMethodDisable implements ObserverInterface
{
    /**
     * @var Checkout
     */
    protected $checkoutSession;
    /**
     * @var Check
     */
    protected $checkData;

    /**
     * @param Check $checkData
     * @param Checkout $checkoutSession
     */
    public function __construct(
        Check    $checkData,
        Checkout $checkoutSession
    ) {
        $this->checkData = $checkData;
        $this->checkoutSession = $checkoutSession;
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
        $shippingMet = $this->checkoutSession->getQuote()->getShippingAddress()->getShippingMethod();
        $result = $observer->getEvent()->getResult();
        if ($shippingMet === 'internationaldelivery_internationaldelivery') {
            if ($paymentMethodCode !== "banktransfer") {
                $result->setData('is_available', false);
            }
        }
    }
}
