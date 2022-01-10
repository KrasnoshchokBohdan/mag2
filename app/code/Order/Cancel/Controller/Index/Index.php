<?php

namespace Order\Cancel\Controller\Index;

use Magento\Sales\Api\OrderManagementInterface;
use Magento\Framework\App\Action\Context;
use Magento\Sales\Controller\AbstractController\OrderLoaderInterface;
use Magento\Framework\Registry;
use Magento\Framework\App\RequestInterface;
use Magento\Checkout\Model\Session;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Json\Helper\Data;
use Magento\Framework\View\Result\PageFactory;
use Psr\Log\LoggerInterface;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\App\Response\Http;

class Index extends \Magento\Framework\App\Action\Action
{
    /**
     * @var OrderManagementInterface
     */
    protected $_order;

    /**
     * @var OrderLoaderInterface
     */
    protected $orderLoader;

    /**
     * @var Registry
     */
    protected $registry;

    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * Cancel constructor.
     * @param OrderManagementInterface $orderManagementInterface
     * @param OrderLoaderInterface $orderLoader
     * @param Registry $registry
     * @param RequestInterface $request
     * @param Context $context
     */
    public function __construct(
        OrderManagementInterface $orderManagementInterface,
        OrderLoaderInterface     $orderLoader,
        Registry                 $registry,
        RequestInterface         $request,
        Context                  $context
    ) {
        $this->_order = $orderManagementInterface;
        $this->orderLoader = $orderLoader;
        $this->registry = $registry;
        $this->request = $request;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $post = $this->getRequest()->getPostValue();

        if (!$post) {
            return $resultRedirect->setPath('*/*/history');
        }

        $orderId = $post['order'];
        $orderStatus = $this->_order->getStatus($orderId);

        if ($orderStatus === "pending") {
            try {
                $this->_order->cancel($orderId);
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                if ($this->_objectManager->get('Magento\Checkout\Model\Session')->getUseNotice(true)) {
                    $this->messageManager->addNotice($e->getMessage());
                } else {
                    $this->messageManager->addError($e->getMessage());
                }
            }
        }
        return $resultRedirect->setPath('*/*/history');
    }
}
