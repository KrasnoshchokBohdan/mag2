<?php

namespace City\Definition\Api;

use City\Definition\Api\Data\CityInterface;

interface CityRepositoryInterface
{
    /**
     * @param CityInterface $request
     * @return mixed
     */
    public function save(CityInterface $request);
}
