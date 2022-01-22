<?php
//@codingStandardsIgnoreStart
namespace City\Definition\Controller\Index;

use City\Definition\Service\IpApiService;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Customer\Model\Session;

class Index extends Action
{
    /**
     * @var IpApiService
     */
    protected $customerSession;

    /**
     * @param Context $context
     * @param Session $customerSession
     */
    public function __construct(
        Context $context,
        Session $customerSession
    ) {
        $this->customerSession = $customerSession;
        parent::__construct($context);
    }

    /**
     * @return string|void
     */
    public function execute()
    {
        $post = $this->getRequest()->getParams();
        if (!$post) {
            return " ";
        }
        $city = $post['content']['0']['value'];

        try {
            $this->customerSession->setMyValue($city);
            $this->messageManager->addSuccess(__('Thank you!'));
        } catch (\Magento\Framework\Exception\LocalizedException|\RuntimeException $e) {
            $this->messageManager->addError($e->getMessage());
        } catch (\Exception $e) {
            $this->messageManager->addException($e, __('Something went wrong . '));
        }
    }
}

