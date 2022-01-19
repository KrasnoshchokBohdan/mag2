<?php

namespace City\Definition\Service;

use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Page;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\HTTP\ZendClientFactory;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Api\SearchCriteriaBuilder;
use City\Definition\Model\CityFactory;
use Zend_Http_Client_Exception;
use City\Definition\Api\CityRepositoryInterface;

class Npcity extends \Magento\Backend\App\Action
{

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

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
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param ZendClientFactory $httpClientFactory
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param ScopeConfigInterface $scopeConfig
     * @param CityRepositoryInterface $cityRepository
     */
    public function __construct(
        CityFactory           $cityFactory,
        Context               $context,
        PageFactory           $resultPageFactory,
        ZendClientFactory     $httpClientFactory,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        ScopeConfigInterface  $scopeConfig,
        CityRepositoryInterface $cityRepository
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->httpClientFactory = $httpClientFactory;
        $this->scopeConfig = $scopeConfig;
        $this->cityFactory = $cityFactory;
        $this->cityRepository = $cityRepository;
    }

    /**
     * Index action
     *
     * @return Page
     * @throws Zend_Http_Client_Exception
     */
    public function execute()
    {
        $citiesApiJson = $this->getCitiesFromServer();
        $citiesApi = json_decode($citiesApiJson);
        if (property_exists($citiesApi, 'success') && $citiesApi->success === true) {
            $this->syncWithDb($citiesApi->data);
        }
    }

    /**
     * @return string|null
     * @throws Zend_Http_Client_Exception
     */
    private function getCitiesFromServer()
    {
        $apiKey = 'cfd16a2e30df401b5005c00d337915d4';//$this->scopeConfig->getValue('carriers/newposhta/apikey', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $client = $this->httpClientFactory->create();
        $client->setUri('http://api.novaposhta.ua/v2.0/json/Address/getCities');
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
     */
    private function syncWithDb($citiesApi)
    {
//        $currentCitiesIds = $this->getCitiesIdArray();
  //      foreach ($citiesApi as $key => $cityApi) {
//            $cityApiId = $cityApi->CityID;
//            if (isset($currentCitiesIds[$cityApiId])) {
//                continue;
//            } else {

 //           $test = $cityApi;

        $cityApi = $citiesApi[0];
                $this->addNewCity($cityApi);
           // }
        }
  //  }
}
