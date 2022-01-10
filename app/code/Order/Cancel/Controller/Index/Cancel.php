<?php

namespace Order\Cancel\Controller\Index;

use Magento\Sales\Api\OrderManagementInterface;
use Magento\Framework\App\Action\Context;
use Magento\Sales\Controller\AbstractController\OrderLoaderInterface;
use Magento\Framework\Registry;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Checkout\Model\Session;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Json\Helper\Data;
use Magento\Framework\View\Result\PageFactory;
use Psr\Log\LoggerInterface;
use Magento\Framework\App\Response\Http;

class Cancel extends \Magento\Framework\App\Action\Action
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
     * @var Json
     */
    protected $serializer;

    /**
     * Cancel constructor.
     * @param OrderManagementInterface $orderManagementInterface
     * @param OrderLoaderInterface $orderLoader
     * @param Registry $registry
     * @param RequestInterface $request
     * @param Json $serializer
     * @param Context $context
     */
    public function __construct(
        OrderManagementInterface $orderManagementInterface,
        OrderLoaderInterface     $orderLoader,
        Registry                 $registry,
        RequestInterface         $request,
        Json               $serializer,
        Context                  $context
    )
    {
        $this->_order = $orderManagementInterface;
        $this->orderLoader = $orderLoader;
        $this->registry = $registry;
        $this->request = $request;
        $this->serializer = $serializer;
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
        //$content = $this->serializer->unserialize($post['content']);
        $content = $post['content'];

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
