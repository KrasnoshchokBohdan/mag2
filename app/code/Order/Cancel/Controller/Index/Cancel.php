<?php

namespace Order\Cancel\Controller\Index;

use Magento\Customer\Model\Session;
use Magento\Sales\Api\OrderManagementInterface;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Registry;
use Order\Cancel\Model\Blog;
use Order\Cancel\Service\Check;
use Magento\Customer\Model\Group;

class Cancel extends \Magento\Framework\App\Action\Action
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
     * @var Blog
     */
    protected $table;

    /**
     * @var Check
     */
    protected $check;

    /**
     * @var Group
     */
    protected $customerGroupCollection;

    /**
     * @param OrderManagementInterface $orderManInterface
     * @param Registry $registry
     * @param Session $customerSession
     * @param Blog $table
     * @param Check $check
     * @param Group $customerGroupCollection
     * @param Context $context
     */
    public function __construct(
        OrderManagementInterface $orderManInterface,
        Registry                 $registry,
        Session                  $customerSession,
        Blog                     $table,
        Check                    $check,
        Group                    $customerGroupCollection,
        Context                  $context

    )
    {
        $this->_order = $orderManInterface;
        $this->registry = $registry;
        $this->table = $table;
        $this->customerSession = $customerSession;
        $this->check = $check;
        $this->customerGroupCollection = $customerGroupCollection;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();

        if (!$this->check->getEnabledModule()) {
            return $resultRedirect->setPath('*/*/history');
        }

        $post = $this->getRequest()->getParams();

        if (!$post) {
            return $resultRedirect->setPath('*/*/history');
        }

        $canceledOrderId = $post['order'];
        $selectedStatus = explode(',', $this->check->getSelectedStatus());
        $orderStatus = $this->_order->getStatus($canceledOrderId);

        if (in_array($orderStatus, $selectedStatus, true)) {
            $this->saveCanseledOrder($post, $canceledOrderId);
            try {
                $this->_order->cancel($canceledOrderId);
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

    public function saveCanseledOrder($post, $canceledOrderId)
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $customer = $this->customerSession->getCustomer();
        $selectedGroups = explode(',', $this->check->getSelectedGroup());
        $customerGroup = $customer->getGroupId();

        if (in_array( $customerGroup, $selectedGroups,true)) {
            $customerName = $customer->getData('firstname') . " " . $customer->getData('lastname');
            $reason = $post['content']['0']['value'];
            $comment = $post['content']['1']['value'];
            $data = [
                'cancel_order_id' => $canceledOrderId,
                'cancel_reason' => $reason,
                'comment' => $comment,
                'canceled_by' => $customerName
            ];
            $order_id = null;
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
                $this->messageManager->addException($e, __('Something went wrong while saving the data.'));
            }
        }
        return $resultRedirect->setPath('*/*/history');;
    }

}
