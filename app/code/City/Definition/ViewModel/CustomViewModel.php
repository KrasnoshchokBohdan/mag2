<?php

namespace City\Definition\ViewModel;

use City\Definition\Service\IpApiService;
use Magento\Backend\Block\Template\Context;

class CustomViewModel implements \Magento\Framework\View\Element\Block\ArgumentInterface
{

    /**
     * @var IpApiService
     */
    protected $ipApiService;

    /**
     * @param Context $context
     * @param IpApiService $ipApiService
     * @param array $data
     */
    public function __construct(
        IpApiService $ipApiService
    ) {
        $this->ipApiService = $ipApiService;
    }

    /**
     * @return string
     */
    public function showCity()
    {
        return $this->ipApiService->sendCity();
    }
}
