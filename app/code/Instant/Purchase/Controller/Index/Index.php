<?php

namespace Instant\Purchase\Controller\Index;

use Magento\Customer\Model\Session;
use Magento\Sales\Api\OrderManagementInterface;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Customer\Model\Group;

class Index extends \Magento\Framework\App\Action\Action
{
    /**
     * @var OrderManagementInterface
     */
    protected $_order;

    /**
     * @var Registry
     */
    protected $registry;

    /**
     * @var Session
     */
    protected $customerSession;

    /**
     * @var Group
     */
    protected $customerGroupCollection;

    /**
     * @param OrderManagementInterface $orderManInterface
     * @param Registry $registry
     * @param Session $customerSession
     * @param Group $customerGroupCollection
     * @param Context $context
     */
    public function __construct(
        OrderManagementInterface $orderManInterface,
        Registry                 $registry,
        Session                  $customerSession,
        Group                    $customerGroupCollection,
        Context                  $context

    ) {
        $this->_order = $orderManInterface;
        $this->registry = $registry;
        $this->customerSession = $customerSession;
        $this->customerGroupCollection = $customerGroupCollection;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $post = $this->getRequest()->getParams();

        if (!$post) {
          //  return $resultRedirect->setPath('*/*/index');
        }

//        $canceledOrderId = $post['order'];
//        $selectedStatus = explode(',', $this->check->getSelectedStatus());
//        $orderStatus = $this->_order->getStatus($canceledOrderId);
//
//        if (in_array($orderStatus, $selectedStatus, true)) {
//            $this->saveCanseledOrder($post, $canceledOrderId);
//            try {
//                $this->_order->cancel($canceledOrderId);
//            } catch (\Magento\Framework\Exception\LocalizedException $e) {
//                if ($this->_objectManager->get('Magento\Checkout\Model\Session')->getUseNotice(true)) {
//                    $this->messageManager->addNotice($e->getMessage());
//                } else {
//                    $this->messageManager->addError($e->getMessage());
//                }
//            }
//        }
       // return $resultRedirect->setPath('*/*/index');
    }
}

