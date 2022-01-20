<?php

namespace City\Definition\ViewModel;

use City\Definition\Service\IpApiService;
use Magento\Backend\Block\Template\Context;
use City\Definition\Service\Check;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use City\Definition\Model\CityFactory;
use City\Definition\Model\City;
use  City\Definition\Model\ResourceModel\City\CollectionFactory;

class CustomViewModel implements ArgumentInterface
{
    /**
     * @var City
     */
    protected $cityCollectionFactory;
    /**
     * @var City
     */
    protected $city;
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
     * @param CollectionFactory $cityCollectionFactory
     * @param CityFactory $cityFactory
     * @param IpApiService $ipApiService
     * @param Check $check
     * @param City $city
     */
    public function __construct(
        CollectionFactory $cityCollectionFactory,
        CityFactory       $cityFactory,
        IpApiService      $ipApiService,
        Check             $check,
        City              $city
    )
    {
        $this->cityCollectionFactory = $cityCollectionFactory;
        $this->cityFactory = $cityFactory;
        $this->ipApiService = $ipApiService;
        $this->check = $check;
        $this->city = $city;
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

    public function getCityNameArray()
    {
        if ($this->moduleEnable()) {
            $cities = $this->cityCollectionFactory->create();
            $test = $cities->addFieldToSelect('*');
         foreach ($test as $elem){
             $arr[] = $elem->getData('city_name_ru');
         }
         return  $arr;
        }
    }
}

