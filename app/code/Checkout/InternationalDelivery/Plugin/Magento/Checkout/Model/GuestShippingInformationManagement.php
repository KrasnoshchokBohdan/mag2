<?php

namespace Checkout\InternationalDelivery\Plugin\Magento\Checkout\Model;

use Magento\Checkout\Api\Data\ShippingInformationInterface;

class GuestShippingInformationManagement
{
    /**
     * @param \Magento\Checkout\Model\GuestShippingInformationManagement $subject
     * @param $result
     * @param $cartId
     * @param ShippingInformationInterface $addressInformation
     * @return mixed
     */
    public function afterSaveAddressInformation(
        \Magento\Checkout\Model\GuestShippingInformationManagement $subject,
        $result,
        $cartId,
        ShippingInformationInterface    $addressInformation
    ) {
        $shippingComment = $addressInformation->getExtensionAttributes();
        $comment = $shippingComment->getComment();
        return $result;
    }
}
