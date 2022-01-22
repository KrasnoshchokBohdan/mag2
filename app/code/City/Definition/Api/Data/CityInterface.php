<?php

namespace City\Definition\Api\Data;

interface CityInterface
{
    /**
     * @param string $cityRef
     * @return mixed
     */
    public function setCityRef(string $cityRef);

    /**
     * @param string $cityNameUa
     * @return mixed
     */
  //  public function setCityNameUa(string $cityNameUa);

    /**
     * @param string $cityNameRu
     * @return mixed
     */
    public function setCityNameRu(string $cityNameRu);

    /**
     * @param string $cityArea
     * @return mixed
     */
    public function setCityArea(string $cityArea);

    /**
     * @param string $cityIdNp
     * @return mixed
     */
   // public function setCityIdNp(string $cityIdNp);

    /**
     * @param string $cityAreaDescUa
     * @return mixed
     */
   // public function setCityAreaDescriptionUa(string $cityAreaDescUa);

    /**
     * @param string $cityAreaDescRu
     * @return mixed
     */
    public function setCityAreaDescriptionRu(string $cityAreaDescRu);
}
