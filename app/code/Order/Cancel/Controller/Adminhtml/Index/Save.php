<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Created By : Rohan Hapani
 */
namespace Order\Cancel\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\Model\Session;
use Order\Cancel\Model\Blog;

class Save extends \Magento\Backend\App\Action
{

    /**
     * @var Blog
     */
    protected $cancel;

    /**
     * @var Session
     */
    protected $adminsession;

    /**
     * @param Action\Context $context
     * @param Blog           $cancel
     * @param Session        $adminsession
     */
    public function __construct(
        Action\Context $context,
        Blog $cancel,
        Session $adminsession
    ) {
        parent::__construct($context);
        $this->cancel = $cancel;
        $this->adminsession = $adminsession;
    }

    /**
     * Save blog record action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();

        $resultRedirect = $this->resultRedirectFactory->create();

        if ($data) {
            $order_id = $this->getRequest()->getParam('order_id');
            if ($order_id) {
                $this->cancel->load($order_id);
            }

            $this->cancel->setData($data);

            try {
                $this->cancel->save();
                $this->messageManager->addSuccess(__('The data has been saved.'));
                $this->adminsession->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    if ($this->getRequest()->getParam('back') == 'add') {
                        return $resultRedirect->setPath('*/*/add');
                    } else {
                        return $resultRedirect->setPath('*/*/edit', ['order_id' => $this->cancel->getBlogId(), '_current' => true]);
                    }
                }

                return $resultRedirect->setPath('*/*/');
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the data.'));
            }

            $this->_getSession()->setFormData($data);
            return $resultRedirect->setPath('*/*/edit', ['order_id' => $this->getRequest()->getParam('order_id')]);
        }

        return $resultRedirect->setPath('*/*/');
    }
}
