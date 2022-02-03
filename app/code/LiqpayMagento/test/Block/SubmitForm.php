<?php

/**
 * LiqPay Extension for Magento 2
 *
 * @author     Volodymyr Konstanchuk http://konstanchuk.com
 * @copyright  Copyright (c) 2017 The authors
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace LiqpayMagento\LiqPay\Block;

use LiqpayMagento\LiqPay\Helper\Data as Helper;
use LiqpayMagento\LiqPay\Sdk\LiqPay;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\LayoutFactory;
use Magento\Sales\Model\Order;
use Magento\Store\Model\StoreManagerInterface;

class SubmitForm extends Template
{
    protected $_order = null;

    /* @var $_liqPay LiqPay */
    protected $_liqPay;

    /* @var $_helper Helper */
    protected $_helper;
    /**
     * @var LayoutFactory
     */
    protected $layoutFactory;
    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    public function __construct(
        Template\Context $context,
        LiqPay $liqPay,
        Helper $helper,
        LayoutFactory $layoutFactory,
        StoreManagerInterface $storeManager,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_liqPay = $liqPay;
        $this->_helper = $helper;
        $this->layoutFactory = $layoutFactory;
        $this->storeManager = $storeManager;
    }

    /**
     * @return Order
     */
    public function getOrder()
    {
        if ($this->_order === null) {
            throw new \Exception('Order is not set');
        }
        return $this->_order;
    }

    public function setOrder(Order $order)
    {
        $this->_order = $order;
    }

    protected function _loadCache()
    {
        return false;
    }

    public function _toHtml()
    {
        $baseUrl = $this->storeManager->getStore()->getBaseUrl();
        $order = $this->getOrder();

        $formBlock = $this->layoutFactory->create()->createBlock('LiqpayMagento\LiqPay\Block\SubmitForm');

        $formBlock->setOrder($order);
        $html = $this->_liqPay->cnb_form([
            'action' => 'pay',
            'amount' => $order->getGrandTotal(),
            'currency' => $order->getOrderCurrencyCode(),
            'description' => $this->_helper->getLiqPayDescription($order),
            'order_id' => $order->getIncrementId(),
            'result_url' => $baseUrl . 'rest/V1/liqpay/callback',
        ]);
        return $html;
    }
}
