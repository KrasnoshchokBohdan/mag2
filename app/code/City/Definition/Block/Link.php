<?php

namespace City\Definition\Block;

use City\Definition\Service\GitApiService;
use Magento\Backend\Block\Template\Context;

class Link extends \Magento\Framework\View\Element\Html\Link
{
    /**
     * @var GitApiService
     */
    protected $gitApiService;

    /**
     * @param Context $context
     * @param GitApiService $gitApiService
     * @param array $data
     */
    public function __construct(
        Context       $context,
        GitApiService $gitApiService,
        array         $data = []
    ) {
        $this->gitApiService = $gitApiService;
        parent::__construct($context, $data);
    }

    /**
     * @return string
     */
    public function showCity()
    {
        return $this->gitApiService->sendCity();
    }
}
