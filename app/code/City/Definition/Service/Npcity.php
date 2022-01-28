<?php

declare(strict_types=1);

namespace City\Definition\Service;

use Magento\Framework\HTTP\ZendClientFactory;
use Magento\Framework\View\Result\PageFactory;
use City\Definition\Model\CityFactory;
use Zend_Http_Client;
use Zend_Http_Client_Exception;
use City\Definition\Api\CityRepositoryInterface;
use City\Definition\Model\City;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Serialize\SerializerInterface;

class Npcity
{
    /**
     * @var SerializerInterface
     */
    protected SerializerInterface $serialize;
    /**
     * @var ResourceConnection
     */
    protected ResourceConnection $connection;
    /**
     * API request URL
     */
    const API_REQUEST_URI = 'http://api.novaposhta.ua/v2.0/json/Address/getCities';
    /**
     * @var Check
     */
    protected Check $check;
    /**
     * @var City
     */
    protected City $city;

    /**
     * @var PageFactory
     */
    protected PageFactory $resultPageFactory;

    /**
     * @var ZendClientFactory
     */
    private ZendClientFactory $httpClientFactory;

    /**
     * @var CityFactory
     */
    private CityFactory $cityFactory;

    /**
     * @var CityRepositoryInterface
     */
    private CityRepositoryInterface $cityRepository;

    /**
     * @param CityFactory $cityFactory
     * @param PageFactory $resultPageFactory
     * @param ZendClientFactory $httpClientFactory
     * @param CityRepositoryInterface $cityRepository
     * @param City $city
     * @param Check $check
     * @param ResourceConnection $connection
     * @param SerializerInterface $serialize
     */
    public function __construct(
        CityFactory             $cityFactory,
        PageFactory             $resultPageFactory,
        ZendClientFactory       $httpClientFactory,
        CityRepositoryInterface $cityRepository,
        City                    $city,
        Check                   $check,
        ResourceConnection      $connection,
        SerializerInterface                    $serialize
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->httpClientFactory = $httpClientFactory;
        $this->cityFactory = $cityFactory;
        $this->cityRepository = $cityRepository;
        $this->city = $city;
        $this->check = $check;
        $this->connection = $connection;
        $this->serialize = $serialize;
    }

    /**
     * Index action
     *
     * @return string
     * @throws Zend_Http_Client_Exception
     */
    public function execute():string
    {
        $citiesApiJson = $this->getCitiesFromServer();
        $citiesApi = $this->serialize->unserialize($citiesApiJson);
        if (is_array($citiesApi)) {
            if (isset($citiesApi['success']) && $citiesApi['success'] == true) {
                $this->syncWithDb($citiesApi['data']);
            }
        }
        return 'Done!';
    }

    /**
     * @return string
     * @throws Zend_Http_Client_Exception
     */
    private function getCitiesFromServer(): string
    {
        $apiKey = $this->check->getNpKey();
        $client = $this->httpClientFactory->create();
        $client->setUri(self::API_REQUEST_URI);
        $request = ['modelName' => 'Address', 'calledMethod' => 'getCities', 'apiKey' => $apiKey];
        $client->setConfig(['maxredirects' => 0, 'timeout' => 30]);
        $row = $this->serialize->serialize($request);
        $client->setRawData((string)$row);
        return $client->request(Zend_Http_Client::POST)->getBody();
    }

    /**
     * @param array<string>  $cityApi
     * @return void
     */
    private function addNewCity(array $cityApi): void
    {
        $modelCity = $this->cityFactory->create();
        $modelCity->setCityRef($cityApi['Ref']);
        $modelCity->setCityNameUa($cityApi['Description']);
        $modelCity->setCityNameRu($cityApi['DescriptionRu']);
        $modelCity->setCityArea($cityApi['Area']);
        $modelCity->setCityIdNp($cityApi['CityID']);
        $modelCity->setCityAreaDescriptionUa($cityApi['AreaDescription']);
        $modelCity->setCityAreaDescriptionRu($cityApi['AreaDescriptionRu']);
        $this->cityRepository->save($modelCity);
    }

    /**
     * @param array<array> $citiesApi
     * @return void
     */
    private function syncWithDb(array $citiesApi)
    {
        $connection = $this->connection->getConnection();
        $tableName = $this->connection->getTableName('city_table');

        $connection->truncateTable($tableName);
        foreach ($citiesApi as $cityApi) {
            $this->addNewCity($cityApi);
        }
    }
}
