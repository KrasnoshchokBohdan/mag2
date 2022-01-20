<?php

namespace City\Definition\ViewModel;

use City\Definition\Service\IpApiService;
use Magento\Backend\Block\Template\Context;
use City\Definition\Service\Check;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use City\Definition\Model\CityFactory;
use phpDocumentor\Reflection\DocBlock\Tags\Reference\Url;

class CustomViewModel implements ArgumentInterface
{

    /**
     * @var CityFactory
     */
    private $cityFactory;
    /**
     * @var IpApiService
     */
    protected $ipApiService;
    /**
     * @var Check
     */
    protected $check;

    /**
     * @param Context $context
     * @param IpApiService $ipApiService
     * @param array $data
     */
    public function __construct(
        CityFactory             $cityFactory,
        IpApiService $ipApiService,
        Check $check
    ) {
        $this->cityFactory = $cityFactory;
        $this->ipApiService = $ipApiService;
        $this->check = $check;
    }

    /**
     * @return mixed
     */
    public function moduleEnable()
    {
       return $this->check->getEnabledModule();
    }
    /**
     * @return string
     */
    public function showCity()
    {
        if ($this->moduleEnable()) {
            return $this->ipApiService->sendCity();
        }
        return "";
    }

    public function getCityArray()
    {
        if ($this->moduleEnable()) {

               $collection = $this->cityFactory->create()->getCollection()
                ->addAttributeToSelect("*")
                ->load();
            return $collection;


        }
    }
}

