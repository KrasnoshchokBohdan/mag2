<?php

namespace City\Definition\CustomerData;

use City\Definition\Service\GitApiService;
use Magento\Customer\CustomerData\SectionSourceInterface;
use Magento\Customer\Model\Session;
use City\Definition\Service\Npcity;

class CustomSection implements SectionSourceInterface
{
    /**
     * @var Npcity
     */
    protected $NpCity;
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
     * @param Npcity $NpCity
     */
    public function __construct(
        Session       $customerSession,
        GitApiService $gitApiService,
        Npcity $NpCity
    ) {
        $this->NpCity = $NpCity;
        $this->gitApiService = $gitApiService;
        $this->customerSession = $customerSession;
    }

    /**
     * @return string[]
     */
    public function getSectionData()
    {
        $cityTest = $this->NpCity->execute();
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
