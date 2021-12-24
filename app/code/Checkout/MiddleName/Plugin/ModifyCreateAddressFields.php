<?php

namespace Checkout\MiddleName\Plugin;

use Magento\Customer\Model\Metadata\Form;
use Magento\Sales\Block\Adminhtml\Order\Create\Shipping\Method\Form as Shipping;

class ModifyCreateAddressFields
{
    /**
     * @var Shipping
     */
    protected $shipping;

    /**
     * @param Shipping $shipping
     */
    public function __construct(
        Shipping $shipping
    ) {
        $this->shipping = $shipping;
    }

    /**
     * @param Form $subject
     * @param array $result
     * @return array<array>
     */
    public function afterGetAttributes(Form $subject, array $result): array
    {
        if (isset($result['middlename'])) {
            $middleName = $result['middlename'];
            if ($this->getShippingMet() == 'freeshipping_freeshipping') {
                $middleName->setIsRequired(true);
            }
        }
        return $result;
    }

    /**
     * @return string
     */
    public function getShippingMet(): string
    {
        if ($this->shipping->getShippingMethod()) {
            return $this->shipping->getShippingMethod();
        }
        return "nope";
    }
}
