<?php

namespace City\Definition\Api\Data;

interface CityInterface
{
    public function setCityRef($city_ref);

    public function setCityNameUa($city_name_ua);

    public function setCityNameRu($city_name_ru);

    public function setCityArea($city_area);

    public function setCityIdNp($city_id_np);

    public function setCityAreaDescriptionUa($city_area_description_ua);

    public function setCityAreaDescriptionRu($city_area_description_ru);
}
