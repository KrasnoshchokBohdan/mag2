<?php

namespace City\Definition\ViewModel;

use City\Definition\Service\IpApiService;
use City\Definition\Service\Check;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use City\Definition\Model\CityFactory;
use City\Definition\Model\City;
use City\Definition\Model\ResourceModel\City\CollectionFactory;

class CustomViewModel implements ArgumentInterface
{
    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;
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
     * @param CollectionFactory $collectionFactory
     * @param CityFactory $cityFactory
     * @param IpApiService $ipApiService
     * @param Check $check
     * @param City $city
     */
    public function __construct(
        CollectionFactory $collectionFactory,
        CityFactory       $cityFactory,
        IpApiService      $ipApiService,
        Check             $check,
        City              $city
    ) {
        $this->collectionFactory = $collectionFactory;
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

    /**
     * @return array|void
     */
    public function getCityNameArray()
    {
        if ($this->moduleEnable()) {
            $cities = $this->collectionFactory->create();

            $allCities = [];
            foreach ($cities->getItems() as $value) {
                $allCities[$value->getData('city_id_np')] = $value->getData('city_name_ru');
            }
            return $allCities;
        }
    }
}






