<?php

namespace City\Definition\Api;

use City\Definition\Api\Data\CityInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

interface CityRepositoryInterface
{
    public function save(CityInterface $request);
}
