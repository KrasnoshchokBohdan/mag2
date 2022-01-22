<?php

//declare(strict_types=1);

namespace City\Definition\Service;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\HTTP\ZendClientFactory;
use Magento\Framework\View\Result\PageFactory;
use City\Definition\Model\CityFactory;
use Zend_Http_Client_Exception;
use City\Definition\Api\CityRepositoryInterface;
use City\Definition\Model\City;

class Npcity
{
    /**
     * API request URL
     */
    const API_REQUEST_URI = 'http://api.novaposhta.ua/v2.0/json/Address/getCities';
    /**
     * @var Check
     */
    protected $check;
    /**
     * @var City
     */
    protected $city;

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var ZendClientFactory
     */
    private $httpClientFactory;

    /**
     * @var CityFactory
     */
    private $cityFactory;

    /**
     * @var CityRepositoryInterface
     */
    private $cityRepository;

    /**
     * @param CityFactory $cityFactory
     * @param PageFactory $resultPageFactory
     * @param ZendClientFactory $httpClientFactory
     * @param ScopeConfigInterface $scopeConfig
     * @param CityRepositoryInterface $cityRepository
     * @param City $city
     * @param Check $check
     */
    public function __construct(
        CityFactory             $cityFactory,
        PageFactory             $resultPageFactory,
        ZendClientFactory       $httpClientFactory,
        ScopeConfigInterface    $scopeConfig,
        CityRepositoryInterface $cityRepository,
        City                    $city,
        Check                   $check
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->httpClientFactory = $httpClientFactory;
        $this->scopeConfig = $scopeConfig;
        $this->cityFactory = $cityFactory;
        $this->cityRepository = $cityRepository;
        $this->city = $city;
        $this->check = $check;
    }

    /**
     * Index action
     *
     * @return string
     * @throws Zend_Http_Client_Exception|LocalizedException
     */
    public function execute()
    {
        $citiesApiJson = $this->getCitiesFromServer();
        $citiesApi = json_decode($citiesApiJson);
        if (property_exists($citiesApi, 'success') && $citiesApi->success === true) {
            $this->syncWithDb($citiesApi->data);
        }
        return "done!";
    }

    /**
     * @return string|null
     * @throws Zend_Http_Client_Exception
     */
    private function getCitiesFromServer()
    {
        $apiKey = $this->check->getNpKey();
        $client = $this->httpClientFactory->create();
        $client->setUri(self::API_REQUEST_URI);
        $request = ['modelName' => 'Address', 'calledMethod' => 'getCities', 'apiKey' => $apiKey];
        $client->setConfig(['maxredirects' => 0, 'timeout' => 30]);
        $client->setRawData(utf8_encode(json_encode($request)));
        return $client->request(\Zend_Http_Client::POST)->getBody();
    }

    /**
     * @param $cityApi
     * @return void
     */
    private function addNewCity($cityApi)
    {
        $modelCity = $this->cityFactory->create();
        $modelCity->setCityRef($cityApi->Ref);
        $modelCity->setCityNameUa($cityApi->Description);
        $modelCity->setCityNameRu($cityApi->DescriptionRu);
        $modelCity->setCityArea($cityApi->Area);
        $modelCity->setCityIdNp($cityApi->CityID);
        $modelCity->setCityAreaDescriptionUa($cityApi->AreaDescription);
        $modelCity->setCityAreaDescriptionRu($cityApi->AreaDescriptionRu);
        $this->cityRepository->save($modelCity);
    }

    /**
     * @param $citiesApi
     * @return void
     * @throws LocalizedException
     */
    private function syncWithDb($citiesApi)
    {
        $connection = $this->city->getResource()->getConnection();
        $tableName = $this->city->getResource()->getMainTable();
        $connection->truncateTable($tableName);

        foreach ($citiesApi as $key => $cityApi) {
            $this->addNewCity($cityApi);
        }
    }
}
