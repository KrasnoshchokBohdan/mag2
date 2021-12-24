<?php

namespace Checkout\TaskFixShip\Model\Carrier;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Quote\Model\Quote\Address\RateRequest;
use Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory;
use Magento\Quote\Model\Quote\Address\RateResult\MethodFactory;
use Magento\Shipping\Model\Carrier\AbstractCarrier;
use Magento\Shipping\Model\Carrier\CarrierInterface;
use Magento\Shipping\Model\Rate\Result;
use Magento\Shipping\Model\Rate\ResultFactory;
use Psr\Log\LoggerInterface;
use Checkout\TaskFixShip\Helper\Data;

/**
 * Class Shipping
 *
 */
class Shipping extends AbstractCarrier implements CarrierInterface
{
    /**
     * @var string
     */
    protected $_code = 'taskfixship';

    /**
     * @var ResultFactory
     */
    protected ResultFactory $_rateResultFactory;

    /**
     * @var MethodFactory
     */
    protected MethodFactory $_rateMethodFactory;

    /**
     * @var Data
     */
    protected Data $helperData;

    /**
     * Shipping constructor.
     *
     * @param ScopeConfigInterface $scopeConfig
     * @param ErrorFactory $rateErrorFactory
     * @param LoggerInterface $logger
     * @param ResultFactory $rateResultFactory
     * @param MethodFactory $rateMethodFactory
     * @param Data $helperData
     * @param array $data
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        ErrorFactory         $rateErrorFactory,
        LoggerInterface      $logger,
        ResultFactory        $rateResultFactory,
        MethodFactory        $rateMethodFactory,
        Data                 $helperData,
        array                $data = []
    ) {
        $this->helperData = $helperData;
        $this->_rateResultFactory = $rateResultFactory;
        $this->_rateMethodFactory = $rateMethodFactory;
        parent::__construct($scopeConfig, $rateErrorFactory, $logger, $data);
    }

    /**
     * get allowed methods
     * @return array
     */
    public function getAllowedMethods()
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
     */
    public function collectRates(RateRequest $request)
    {
        if (!$this->getConfigFlag('active')) {
            return false;
        }

        if ($request->getData('dest_city') == null || $request->getData('dest_postcode') == null) {
            return false;
        }

        $result = $this->_rateResultFactory->create();

        $method = $this->_rateMethodFactory->create();
        $method->setCarrier($this->_code);
        $method->setCarrierTitle($this->getConfigData('title'));
        $method->setMethod($this->_code);
        $method->setMethodTitle($this->getConfigData('name'));
        $amount = $this->getShippingPrice();

        if ($this->helperData->getEnabledCounties()) {
            $str = $this->helperData->getGeneralConfig('country_discount');
            $arr = explode(",", $str);
            $country = $request->getData('dest_country_id');
            if (in_array($country, $arr)) {
                $discount = $this->helperData->getGeneralConfig('percent');
                $res = $amount - ($amount * $discount) / 100;
                $amount = $res;
            }
        }

        if ($this->helperData->getEnabledCities()) {
            $str = $this->helperData->getGeneralConfig('city_freeshipping');
            $arr = explode(",", $str);
            $city = $request->getData('dest_city');
            if (in_array($city, $arr)) {
                $amount = 0;
            }
        }

        $method->setPrice($amount);
        $method->setCost($amount);
        $result->append($method);
        return $result;
    }
}
