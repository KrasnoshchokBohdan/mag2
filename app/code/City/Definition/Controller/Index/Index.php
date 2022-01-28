<?php

namespace City\Definition\Controller\Index;

use City\Definition\Service\IpApiService;
use Exception;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use RuntimeException;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\Message\ManagerInterface;

class Index implements ActionInterface
{
    /**
     * @var IpApiService
     */
    protected $customerSession;

    /**
     * @var ManagerInterface
     */
    protected ManagerInterface $messageManager;

    /**
     * @var Context
     */
    private Context $context;

    /**
     * @param ManagerInterface $messageManager
     * @param Session $customerSession
     * @param Context $context
     */
    public function __construct(
        ManagerInterface $messageManager,
        Session $customerSession,
        Context $context
    ) {
        $this->customerSession = $customerSession;
        $this->messageManager = $messageManager;
        $this->context = $context;
    }

    /**
     * @return ResponseInterface|ResultInterface|void
     */
    public function execute()
    {
        $post = $this->context->getRequest()->getParams();
        $city = $post['content']['0']['value'];

        try {
            $this->customerSession->setMyValue($city);
            $this->messageManager->addSuccessMessage('Thank you!');

        } catch (LocalizedException|RuntimeException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());

        } catch (Exception $e) {
            $this->messageManager->addExceptionMessage($e, __('Something went wrong . '));
        }
    }
}
