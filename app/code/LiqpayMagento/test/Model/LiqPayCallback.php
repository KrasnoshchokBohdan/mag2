<?php

/**
 * LiqPay Extension for Magento 2
 *
 * @author     Volodymyr Konstanchuk http://konstanchuk.com
 * @copyright  Copyright (c) 2017 The authors
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 */

namespace LiqpayMagento\LiqPay\Model;

use LiqpayMagento\LiqPay\Api\LiqPayCallbackInterface;
use LiqpayMagento\LiqPay\Helper\Data as Helper;
use LiqpayMagento\LiqPay\Sdk\LiqPay;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResponseFactory;
use Magento\Framework\DB\Transaction;
use Magento\Framework\UrlInterface;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Sales\Model\Order;
use Magento\Sales\Model\Order\Status\HistoryFactory;
use Magento\Sales\Model\Service\InvoiceService;

class LiqPayCallback implements LiqPayCallbackInterface
{
    /**
     * @var \Magento\Sales\Model\Order
     */
    protected $_order;

    /**
     * @var \LiqPayMagento\LiqPay\Sdk\LiqPay
     */
    protected $_LiqPay;

    /**
     * @var \Magento\Sales\Api\OrderRepositoryInterface
     */
    protected $_orderRepository;

    /**
     * @var \Magento\Sales\Model\Service\InvoiceService
     */
    protected $_invoiceService;

    /**
     * @var \Magento\Framework\DB\Transaction
     */
    protected $_transaction;

    /**
     * @var Helper
     */
    protected $_helper;

    /**
     * @var RequestInterface
     */
    protected $_request;
    /**
     * @var UrlInterface
     */
    private $url;
    /**
     * @var ResponseFactory
     */
    private $responseFactory;
    /**
     * @var HistoryFactory
     */
    private $orderHistoryFactory;

    public function __construct(
        Order $order,
        OrderRepositoryInterface $orderRepository,
        InvoiceService $invoiceService,
        Transaction $transaction,
        Helper $helper,
        LiqPay $LiqPay,
        RequestInterface $request,
        UrlInterface $url,
        ResponseFactory $responseFactory,
        HistoryFactory $orderHistoryFactory
    ) {
        $this->_order = $order;
        $this->_LiqPay = $LiqPay;
        $this->_orderRepository = $orderRepository;
        $this->_invoiceService = $invoiceService;
        $this->_transaction = $transaction;
        $this->_helper = $helper;
        $this->_request = $request;
        $this->url = $url;
        $this->responseFactory = $responseFactory;
        $this->orderHistoryFactory = $orderHistoryFactory;
    }

    public function callback()
    {
        $post = $this->_request->getParams();
        if (!(isset($post['data']) && isset($post['signature']))) {
            $this->_helper->getLogger()->error(__('In the response from LiqPay server there are no POST parameters "data" and "signature"'));
            return null;
        }

        $data = $post['data'];
        $receivedSignature = $post['signature'];
        $decodedData = $this->_LiqPay->getDecodedData($data);
        $orderId = trim(($decodedData['order_id']), '-test') ?? null;
        $receivedPublicKey = $decodedData['public_key'] ?? null;
        $status = $decodedData['status'] ?? null;
        $amount = $decodedData['amount'] ?? null;
        $currency = $decodedData['currency'] ?? null;
        $transactionId = $decodedData['transaction_id'] ?? null;
        $senderPhone = $decodedData['sender_phone'] ?? null;

        try {
            $order = $this->getRealOrder($status, $orderId);
            if (!($order && $order->getId() && $this->_helper->checkOrderIsLiqPayPayment($order))) {
                return null;
            }

            // ALWAYS CHECK signature field from LiqPay server!!!!
            // DON'T delete this block, be careful of fraud!!!
            if (!$this->_helper->securityOrderCheck($data, $receivedPublicKey, $receivedSignature)) {
                $order->addStatusHistoryComment(__('LiqPay security check failed!'));
                $this->_orderRepository->save($order);
                return null;
            }

            $historyMessage = [];
            $state = null;
            switch ($status) {
                case LiqPay::STATUS_SANDBOX:
                case LiqPay::STATUS_WAIT_COMPENSATION:
                // case LiqPay::STATUS_SUBSCRIBED:
                case LiqPay::STATUS_SUCCESS:
                    if ($order->canInvoice()) {
                        $invoice = $this->_invoiceService->prepareInvoice($order);
                        $invoice->register()->pay();
                        $transactionSave = $this->_transaction->addObject(
                            $invoice
                        )->addObject(
                            $invoice->getOrder()
                        );
                        $transactionSave->save();
                        if ($status == LiqPay::STATUS_SANDBOX) {
                            $historyMessage[] = __('Invoice #%1 created (sandbox).', $invoice->getIncrementId());
                        } else {
                            $historyMessage[] = __('Invoice #%1 created.', $invoice->getIncrementId());
                        }
                        $state = \Magento\Sales\Model\Order::STATE_PROCESSING;
                    } else {
                        $historyMessage[] = __('Error during creation of invoice.');
                    }
                    if ($senderPhone) {
                        $historyMessage[] = __('Sender phone: %1.', $senderPhone);
                    }
                    if ($amount) {
                        $historyMessage[] = __('Amount: %1.', $amount);
                    }
                    if ($currency) {
                        $historyMessage[] = __('Currency: %1.', $currency);
                    }
                    break;
                case LiqPay::STATUS_FAILURE:
                    $state = \Magento\Sales\Model\Order::STATE_CANCELED;
                    $historyMessage[] = __('LiqPay invoice canceled.');
                    break;
                case LiqPay::STATUS_ERROR:
                    $state = \Magento\Sales\Model\Order::STATE_CANCELED;
                    $historyMessage[] = __('LiqPay error.');
                    break;
                case LiqPay::STATUS_WAIT_SECURE:
                    $state = \Magento\Sales\Model\Order::STATE_PROCESSING;
                    $historyMessage[] = __('Waiting for verification from the LiqPay side.');
                    break;
                case LiqPay::STATUS_WAIT_ACCEPT:
                    $state = \Magento\Sales\Model\Order::STATE_PROCESSING;
                    $historyMessage[] = __('Waiting for accepting from the buyer side by LiqPay');
                    break;
                case LiqPay::STATUS_WAIT_CARD:
                    $state = \Magento\Sales\Model\Order::STATE_PROCESSING;
                    $historyMessage[] = __('Waiting for setting refund card number into your LiqPay shop.');
                    break;
                default:
                    $historyMessage[] = __('Unexpected status from LiqPay server: %1', $status);
                    break;
            }
            if ($transactionId) {
                $historyMessage[] = __('LiqPay transaction id %1.', $transactionId);
            }
            if (count($historyMessage)) {
                $order->addStatusHistoryComment(implode(' ', $historyMessage))
                    ->setIsCustomerNotified(true);
            }
            if ($state) {
                $order->setState($state);
                $order->setStatus($state);
                $order->save();
            }
            $this->_orderRepository->save($order);
            $redirectionUrl = $this->url->getUrl('checkout/onepage/success');
            $this->responseFactory->create()->setRedirect($redirectionUrl)->sendResponse();
        } catch (\Exception $e) {
            $this->_helper->getLogger()->critical($e);
        }
        return null;
    }

    protected function getRealOrder($status, $orderId)
    {
        if ($status == LiqPay::STATUS_SANDBOX) {
            $testOrderSuffix = $this->_helper->getTestOrderSurfix();
            if (!empty($testOrderSuffix)) {
                $testOrderSuffix = LiqPay::TEST_MODE_SURFIX_DELIM . $testOrderSuffix;
                if (strlen($testOrderSuffix) < strlen($orderId)
                    && substr($orderId, -strlen($testOrderSuffix)) == $testOrderSuffix
                ) {
                    $orderId = substr($orderId, 0, strlen($orderId) - strlen($testOrderSuffix));
                }
            }
        }
        return $this->_order->loadByIncrementId($orderId);
    }
}
