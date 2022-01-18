<?php

namespace City\Definition\Block;

use City\Definition\Service\GitApiService;
use Magento\Backend\Block\Template\Context;
use Magento\Customer\Model\Session;

class Link extends \Magento\Backend\Block\Template
{
    /**
     * @var Session
     */
    protected $customerSession;

    /**
     * @var GitApiService
     */
    protected $gitApiService;

    /**
     * @param Session $customerSession
     * @param Context $context
     * @param GitApiService $gitApiService
     * @param array $data
     */
    public function __construct(
        Session $customerSession,
        Context       $context,
        GitApiService $gitApiService,
        array         $data = []
    ) {
        $this->customerSession = $customerSession;
        $this->gitApiService = $gitApiService;
        parent::__construct($context, $data);
    }



    /**
     * @return string
     */
    public function showCity()
    {
        $session= $this->customerSession->getCustomer()->getData();
        return $this->gitApiService->sendCity();
    }
}
