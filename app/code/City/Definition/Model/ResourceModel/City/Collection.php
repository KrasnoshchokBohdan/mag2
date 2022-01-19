<?php

namespace City\Definition\Model\ResourceModel\City;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use City\Definition\Model\City as CityModel;
use City\Definition\Model\ResourceModel\City as CityResourceModel;

class Collection extends AbstractCollection
{
    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(CityModel::class, CityResourceModel::class);
    }
}
