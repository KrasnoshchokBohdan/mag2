<?php
namespace Perspective\AllPaymentMethods\Block;
class Index extends \Magento\Framework\View\Element\Template
{

protected $_paymentHelper;

public function __construct(
    \Magento\Backend\Block\Template\Context $context,
     \Magento\Payment\Helper\Data $paymentHelper,
      array $data = []
) {
    $this->_paymentHelper = $paymentHelper;
    parent::__construct($context, $data);
}

public function getAllPaymentMethods() 
{
    return $this->_paymentHelper->getPaymentMethods();
}
}
