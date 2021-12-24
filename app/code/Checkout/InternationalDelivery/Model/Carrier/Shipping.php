<?php

namespace Checkout\InternationalDelivery\Model\Carrier;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Quote\Model\Quote\Address\RateRequest;
use Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory;
use Magento\Quote\Model\Quote\Address\RateResult\MethodFactory;
use Magento\Shipping\Model\Carrier\AbstractCarrier;
use Magento\Shipping\Model\Carrier\CarrierInterface;
use Magento\Shipping\Model\Rate\Result;
use Magento\Shipping\Model\Rate\ResultFactory;
use Psr\Log\LoggerInterface;
use Checkout\InternationalDelivery\Service\Check;
use Magento\Checkout\Model\Session as Checkout;

class Shipping extends AbstractCarrier implements CarrierInterface
{
    /**
     * @var string
     */
    protected $_code = 'internationaldelivery';

    /**
     * @var ResultFactory
     */
    protected $_rateResultFactory;

    /**
     * @var MethodFactory
     */
    protected $_rateMethodFactory;

    /**
     * @var Check
     */
    protected $checkData;

    /**
     * @var Checkout
     */
    protected $checkoutSession;

    /**
     * Shipping constructor.
     *
     * @param ScopeConfigInterface $scopeConfig
     * @param ErrorFactory $rateErrorFactory
     * @param LoggerInterface $logger
     * @param ResultFactory $rateResultFactory
     * @param MethodFactory $rateMethodFactory
     * @param Check  $checkData
     * @param Checkout $checkoutSession
     * @param array<array> $data
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        ErrorFactory         $rateErrorFactory,
        LoggerInterface      $logger,
        ResultFactory        $rateResultFactory,
        MethodFactory        $rateMethodFactory,
        Check                 $checkData,
        Checkout             $checkoutSession,
        array                $data = []
    ) {
        $this->checkData = $checkData;
        $this->_rateResultFactory = $rateResultFactory;
        $this->_rateMethodFactory = $rateMethodFactory;
        $this->checkoutSession = $checkoutSession;
        parent::__construct($scopeConfig, $rateErrorFactory, $logger, $data);
    }

    /**
     * get allowed methods
     * @return array<string, bool|string>
     */
    public function getAllowedMethods(): array
    {
        return [$this->_code => $this->getConfigData('name')];
    }

    /**
     * @return float|int
     */
    protected function getShippingPrice()
    {
        $configPrice = $this->getConfigData('price');
        return $this->getFinalPriceWithHandlingFee($configPrice);
    }

    /**
     * @param RateRequest $request
     * @return bool|Result
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function collectRates(RateRequest $request)
    {
        if (!$this->getConfigFlag('active')) {
            return false;
        }

        $result = $this->_rateResultFactory->create();
        $method = $this->_rateMethodFactory->create();
        $method->setCarrier($this->_code);
        $method->setCarrierTitle($this->getConfigData('title'));
        $method->setMethod($this->_code);
        $method->setMethodTitle($this->getConfigData('name'));
        $amount = $this->getShippingPrice();
        $method->setPrice($this->getNewAmount($amount));
        $method->setCost($amount);
        $result->append($method);
        return $result;
    }

    /**
     * @param float|int $amount
     * @return float|int
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function getNewAmount($amount)
    {
        $items = $this->checkoutSession->getQuote()->getAllItems();
        $weight = 0;

        foreach ($items as $item) {
            if ($item->getWeight() > 0) {
                if ($item->getQty() > 1) {
                    $weight = $item->getQty() * $item->getWeight();
                } else {
                    $weight += $item->getWeight();
                }
            }
        }
        return $amount + 2 * $weight;
    }
}
