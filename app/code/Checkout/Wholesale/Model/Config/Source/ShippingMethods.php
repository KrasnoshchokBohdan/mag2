<?php

namespace Checkout\Wholesale\Model\Config\Source;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Data\OptionSourceInterface;
use Magento\Shipping\Model\Config;

class ShippingMethods implements OptionSourceInterface
{
    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;
    /**
     * @var Config
     */
    protected $shipconfig;

    public function __construct(
        ScopeConfigInterface $scopeConfig,
        Config                     $shipconfig
    ) {
        $this->shipconfig = $shipconfig;
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * getShippingMethods
     * @return array<array>
     */
    public function getShippingMethods(): array
    {
        $activeCarriers = $this->shipconfig->getActiveCarriers();
        $methods = [];

        foreach ($activeCarriers as $carrierCode => $carrierModel) {
            $options = [];
            if ($carrierMethods = $carrierModel->getAllowedMethods()) {
                foreach ($carrierMethods as $methodCode => $method) {
                    $code = $carrierCode;   //. '_' . $methodCode;
                    $options[] = ['value' => $code, 'label' => $method];
                }
                $carrierTitle = $this->scopeConfig->getValue('carriers/' . $carrierCode . '/title');
            }
            $methods[] = ['value' => $options, 'label' => $carrierTitle];
        }

        return $methods;
    }

    /**
     * Retrieve Custom Option array
     * @return  array<array>
     */
    public function toOptionArray(): array
    {
        return $this->getShippingMethods();
    }
}
