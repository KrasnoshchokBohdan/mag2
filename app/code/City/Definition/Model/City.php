<?php

namespace City\Definition\Model;

use City\Definition\Api\Data\CityInterface;
use Magento\Framework\Model\AbstractModel;
use City\Definition\Model\ResourceModel\City as CityResourceModel;

class City extends AbstractModel implements CityInterface
{
    protected function _construct()
    {
        $this->_init(CityResourceModel::class);
    }

    /**
     * @param string $cityRef
     * @return string
     */
    public function setCityRef(string $cityRef): string
    {
        $this->setData('city_ref', $cityRef);
        return "Done!";
    }

    /**
     * @return string
     */
    public function getCityRef(): string
    {
        return $this->_getData('city_ref');
    }

    /**
     * @param string $cityNameUa
     * @return string
     */
    public function setCityNameUa(string $cityNameUa): string
    {
        $this->setData('city_name_ua', $cityNameUa);
        return "Done!";
    }

    /**
     * @return string
     */
    public function getCityNameUa(): string
    {
        return $this->_getData('city_name_ua');
    }

    /**
     * @param string $cityNameRu
     * @return string
     */
    public function setCityNameRu(string $cityNameRu): string
    {
        $this->setData('city_name_ru', $cityNameRu);
        return "Done!";
    }

    /**
     * @return string
     */
    public function getCityNameRu(): string
    {
        return $this->_getData('city_name_ru');
    }

    /**
     * @param string $cityArea
     * @return string
     */
    public function setCityArea(string $cityArea): string
    {
        $this->setData('city_area', $cityArea);
        return "Done!";
    }

    /**
     * @return string
     */
    public function getCityArea(): string
    {
        return $this->_getData('city_area');
    }

    /**
     * @param string $cityIdNp
     * @return string
     */
    public function setCityIdNp(string $cityIdNp): string
    {
        $this->setData('city_id_np', $cityIdNp);
        return "Done!";
    }

    /**
     * @return string
     */
    public function getCityIdNp(): string
    {
        return $this->_getData('city_id_np');
    }

    /**
     * @param string $cityAreaDescUa
     * @return string
     */
    public function setCityAreaDescriptionUa(string $cityAreaDescUa): string
    {
        $this->setData('city_area_description_ua', $cityAreaDescUa);
        return "Done!";
    }

    /**
     * @return string
     */
    public function getCityAreaDescriptionUa(): string
    {
        return $this->_getData('city_area_description_ua');
    }

    /**
     * @param string $cityAreaDescRu
     * @return string
     */
    public function setCityAreaDescriptionRu(string $cityAreaDescRu): string
    {
        $this->setData('city_area_description_ru', $cityAreaDescRu);
        return "Done!";
    }

    /**
     * @return string
     */
    public function getCityAreaDescriptionRu(): string
    {
        return $this->_getData('city_area_description_ru');
    }
}
