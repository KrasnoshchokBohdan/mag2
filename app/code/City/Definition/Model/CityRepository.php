<?php

namespace City\Definition\Model;

use City\Definition\Api\CityRepositoryInterface;
use City\Definition\Api\Data\CityInterface;
use City\Definition\Model\ResourceModel\City as CityResource;
use Magento\Framework\Exception\AlreadyExistsException;

class CityRepository implements CityRepositoryInterface
{

    /**
     * @var CityResource
     */
    private CityResource $cityResource;

    public function __construct(
        CityResource $cityResource
    ) {
        $this->cityResource = $cityResource;
    }

    /**
     * @param CityInterface $city
     * @return int
     * @throws AlreadyExistsException
     */
    public function save(CityInterface $city):int
    {
        $this->cityResource->save($city);
        return $city->getId();
    }
}
