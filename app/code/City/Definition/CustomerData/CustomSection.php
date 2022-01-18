<?php

namespace City\Definition\CustomerData;

use City\Definition\Service\GitApiService;
use Magento\Customer\CustomerData\SectionSourceInterface;
use Magento\Customer\Model\Session;

class CustomSection implements SectionSourceInterface
{
    /**
     * @var CookieManagerInterface
     */
    protected $cookieManager;

    /**
     * @var GitApiService
     */
    protected $gitApiService;

    /**
     * @var GitApiService
     */
    protected $customerSession;

    /**
     * @param Session $customerSession
     * @param GitApiService $gitApiService
     */
    public function __construct(
        Session       $customerSession,
        GitApiService $gitApiService
    ) {
        $this->gitApiService = $gitApiService;
        $this->customerSession = $customerSession;
    }

    /**
     * @return string[]
     */
    public function getSectionData()
    {
        $cityIp = $this->gitApiService->sendCity();
        $cityForm = $this->customerSession->getMyValue();
        if ($cityForm) {
            $cityIp = $cityForm;
        }

        return [
            'customdata' => $cityIp,
        ];
    }
}
