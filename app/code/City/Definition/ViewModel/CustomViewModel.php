<?php

namespace City\Definition\ViewModel;

use City\Definition\Service\IpApiService;
use City\Definition\Service\Check;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use City\Definition\Model\City;
use City\Definition\Model\ResourceModel\City\CollectionFactory;

class CustomViewModel implements ArgumentInterface
{
    /**
     * @var CollectionFactory
     */
    protected CollectionFactory $collectionFactory;
    /**
     * @var City
     */
    protected City $city;
    /**
     * @var IpApiService
     */
    protected IpApiService $ipApiService;
    /**
     * @var Check
     */
    protected Check $check;

    /**
     * @param CollectionFactory $collectionFactory
     * @param IpApiService $ipApiService
     * @param Check $check
     * @param City $city
     */
    public function __construct(
        CollectionFactory $collectionFactory,
        IpApiService      $ipApiService,
        Check             $check,
        City              $city
    ) {
        $this->collectionFactory = $collectionFactory;
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
    public function showCity(): string
    {
        if ($this->moduleEnable()) {
            return $this->ipApiService->sendCity();
        }
        return "";
    }

    /**
     * @return array<array>
     */
    public function getCityNameArray(): array
    {
            $cities = $this->collectionFactory->create();

            $allCities = [];
        foreach ($cities->getItems() as $value) {
            $allCities[$value->getData('city_id_np')] = $value->getData('city_name_ru');
        }
            return $allCities;
    }
}
