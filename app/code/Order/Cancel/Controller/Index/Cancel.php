<?php

namespace Order\Cancel\Controller\Index;

use Magento\Sales\Api\OrderManagementInterface;
use Magento\Framework\App\Action\Context;
use Magento\Sales\Controller\AbstractController\OrderLoaderInterface;
use Magento\Framework\Registry;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Serialize\Serializer\Json;
use Order\Cancel\Model\Blog;
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
     * @var Blog
     */
    protected $table;

    /**
     * Cancel constructor.
     * @param OrderManagementInterface $orderManInterface
     * @param OrderLoaderInterface $orderLoader
     * @param Registry $registry
     * @param RequestInterface $request
     * @param Context $context
     * @param Json $serializer
     * @param Blog $table
     */
    public function __construct(
        OrderManagementInterface $orderManInterface,
        OrderLoaderInterface     $orderLoader,
        Registry                 $registry,
        RequestInterface         $request,
        Context                  $context,
        Json                     $serializer,
        Blog                     $table

    )
    {
        $this->_order = $orderManInterface;
        $this->orderLoader = $orderLoader;
        $this->registry = $registry;
        $this->request = $request;
        parent::__construct($context);
        $this->serializer = $serializer;
        $this->table = $table;

    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $post = $this->getRequest()->getPostValue();

        if (!$post) {
            return $resultRedirect->setPath('*/*/history');
        }

        $data = [
            'cancel_order_id' => '000000111',
            'cancel_reason' => 'test1',
            'comment' => 'test2',
            'canceled_by' => 'test3'
        ];

        $order_id = null;
        if ($data) {
            $this->table->load($order_id);
            $this->table->setData($data);

            try {
                $this->table->save();
                $this->messageManager->addSuccess(__('The data has been saved.'));

            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the data111111111.'));
            }

        }


        $orderId = $post['order'];
        $content = $post['content'];
       // $content = $this->serializer->unserialize($post['content']);
       //

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
