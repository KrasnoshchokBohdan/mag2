<?php

namespace City\Definition\Model;

use Magento\Framework\Model\AbstractModel;
use City\Definition\Model\ResourceModel\City as CityResourceModel;

class City extends \Magento\Framework\Model\AbstractModel
{
    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(CityResourceModel::class);
    }

    public function setCityRef($city_ref)
    {
        return $this->setData('city_ref', $city_ref);
    }
    public function getCityRef()
    {
        return $this->_getData('city_ref');
    }


    public function setCityNameUa($city_name_ua)
    {
        return $this->setData('city_name_ua', $city_name_ua);
    }
    public function getCityNameUa()
    {
        return $this->_getData('city_name_ua');
    }


    public function setCityNameRu($city_name_ru)
    {
        return $this->setData('city_name_ru', $city_name_ru);
    }
    public function getCityNameRu()
    {
        return $this->_getData('city_name_ru');
    }


    public function setCityArea($city_area)
    {
        return $this->setData('city_area', $city_area);
    }
    public function getCityArea()
    {
        return $this->_getData('city_area');
    }


    public function setCityIdNp($city_id_np)
    {
        return $this->setData('city_id_np', $city_id_np);
    }
    public function getCityIdNp()
    {
        return $this->_getData('city_id_np');
    }


    public function setCityAreaDescriptionUa($city_area_description_ua)
    {
        return $this->setData('city_area_description_ua', $city_area_description_ua);
    }
    public function getCityAreaDescriptionUa()
    {
        return $this->_getData('city_area_description_ua');
    }


    public function setCityAreaDescriptionRu($city_area_description_ru)
    {
        return $this->setData('city_area_description_ru', $city_area_description_ru);
    }
    public function getCityAreaDescriptionRu()
    {
        return $this->_getData('city_area_description_ru');
    }
}

