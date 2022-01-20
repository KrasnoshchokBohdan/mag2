<?php

namespace City\Definition\Model;

use City\Definition\Api\CityRepositoryInterface;
use City\Definition\Model\ResourceModel\City as CityResource;
use City\Definition\Model\ResourceModel\City\Collection;
use City\Definition\Model\ResourceModel\City\CollectionFactory;
use City\Definition\Api\Data\CityInterfaceFactory as CityDataFactory;
use Magento\Framework\Api\SearchCriteriaInterface;

class CityRepository implements CityRepositoryInterface
{

    /**
     * @var CityResource
     */
    private $cityResource;

    /**
     * @var CityFactory
     */
    private $cityFactory;

    /**
     * @var CollectionFactory
     */
    private $cityDataFactory;

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;



    public function __construct(
        CityResource                      $cityResource,
        CityFactory                       $cityFactory,
        CollectionFactory                 $collectionFactory,
        Collection                        $citycollection,
        CityDataFactory                   $cityDataFactory
    ) {

        $this->cityResource = $cityResource;
        $this->cityFactory = $cityFactory;
        $this->collectionFactory = $collectionFactory;
        $this->citycollection = $citycollection;
        $this->cityDataFactory = $cityDataFactory;
    }

    /**
     * @param \City\Definition\Api\Data\CityInterface|\City\Definition\Api\Data\CityInterface $city
     * @return int
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function save($city)  //\City\Definition\Api\Data\CityInterface
    {
        $this->cityResource->save($city);
        return $city->getId();
    }
}
