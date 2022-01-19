<?php

namespace City\Definition\CustomerData;

use City\Definition\Service\IpApiService;
use Magento\Customer\CustomerData\SectionSourceInterface;
use Magento\Customer\Model\Session;
use City\Definition\Service\Npcity;

class CustomSection implements SectionSourceInterface
{
    /**
     * @var Npcity
     */
    protected $npCity;
    /**
     * @var CookieManagerInterface
     */
    protected $cookieManager;

    /**
     * @var IpApiService
     */
    protected $ipApiService;

    /**
     * @var Session
     */
    protected $customerSession;

    /**
     * @param Session $customerSession
     * @param IpApiService $ipApiService
     * @param Npcity $npCity
     */
    public function __construct(
        Session      $customerSession,
        IpApiService $ipApiService,
        Npcity       $npCity
    ) {
        $this->npCity = $npCity;
        $this->ipApiService = $ipApiService;
        $this->customerSession = $customerSession;
    }

    /**
     * @return string[]
     */
    public function getSectionData(): array
    {
        $cityTest = $this->npCity->execute();
        $cityIp = $this->ipApiService->sendCity();
        $cityForm = $this->customerSession->getMyValue();
        if ($cityForm) {
            $cityIp = $cityForm;
        }

        return [
            'customdata' => $cityIp,
        ];
    }
}
