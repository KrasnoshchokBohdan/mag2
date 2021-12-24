<?php

namespace Checkout\Wholesale\Model\Config\Source;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Data\OptionSourceInterface;
use Magento\Payment\Helper\Data;
use Magento\Payment\Model\Config;
use Magento\Sales\Model\ResourceModel\Order\Payment\Collection;

class PaymentMethods implements OptionSourceInterface
{
    /**
     * Order Payment
     *
     * @var Collection<Collection>
     */
    protected $orderPayment;

    /**
     * Payment Helper Data
     *
     * @var Data
     */
    protected $paymentHelper ;

    /**
     * Payment Model Config
     *
     * @var Config
     */
    protected $paymentConfig;
    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfigInterface;

    /**
     * @param Collection $orderPayment
     * @param Data $paymentHelper
     * @param Config $paymentConfig
     * @param ScopeConfigInterface $scopeConfigInterface
     */
    public function __construct(
        Collection                      $orderPayment,
        Data                                $paymentHelper,
        Config                               $paymentConfig,
        ScopeConfigInterface          $scopeConfigInterface
    ) {
        $this->orderPayment = $orderPayment;
        $this->paymentHelper  = $paymentHelper;
        $this->paymentConfig = $paymentConfig;
        $this->scopeConfigInterface = $scopeConfigInterface;
    }

    /**
     * Get all payment methods
     *
     * @return array<array>
     */
    public function getAllPaymentMethods(): array
    {
        return $this->paymentHelper ->getPaymentMethods();
    }

    /**
     * Get key-value pair of all payment methods
     * key = method code & value = method name
     *
     * @return array<array>
     */
    public function getAllPaymentMethodsList(): array
    {
        return $this->paymentHelper ->getPaymentMethodList();
    }

    /**
     * Get active/enabled payment methods
     *
     * @return array<array>
     */
    public function getActivePaymentMethods(): array
    {
        $payments = $this->paymentConfig->getActiveMethods();
        $methods = [];
        foreach ($payments as $paymentCode => $paymentModel) {
            $paymentTitle = $this->scopeConfigInterface
                ->getValue('payment/' . $paymentCode . '/title');
            $methods[$paymentCode] = [
                'label' => $paymentTitle,
                'value' => $paymentCode
            ];
        }
        return $methods;
    }

    /**
     * Get payment methods that have been used for orders
     *
     * @return array<array>
     */
    public function getUsedPaymentMethods(): array
    {
        $collection = $this->orderPayment;
        $collection->getSelect()->group('method');
        $paymentMethods[] = ['value' => '', 'label' => 'Any'];
        foreach ($collection as $col) {
            $paymentMethods[] = ['value' => $col->getMethod(),
                'label' => $col->getAdditionalInformation()['method_title']];
        }
        return $paymentMethods;
    }

    /**
     * Retrieve Custom Option array
     * @return array<array>
     */
    public function toOptionArray(): array
    {
        return $this->getActivePaymentMethods();
    }
}
