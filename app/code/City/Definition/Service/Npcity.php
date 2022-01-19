<?php

namespace City\Definition\Service;

use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Page;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\HTTP\ZendClientFactory;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Api\SearchCriteriaBuilder;

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
    private $_httpClientFactory;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param CityRepositoryInterface $cityRepository
     * @param CityFactory $cityFactory
     * @param ZendClientFactory $httpClientFactory
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        Context               $context,
        PageFactory           $resultPageFactory,
        ZendClientFactory     $httpClientFactory,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        ScopeConfigInterface  $scopeConfig
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->_httpClientFactory = $httpClientFactory;
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Index action
     *
     * @return Page
     */
    public function execute()
    {

        $citiesApiJson = $this->_getCitiesFromServer();
        $citiesApi = json_decode($citiesApiJson);
        return $citiesApi;
    }

    private function _getCitiesFromServer()
    {
        $apiKey = 'cfd16a2e30df401b5005c00d337915d4';//$this->scopeConfig->getValue('carriers/newposhta/apikey', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $client = $this->_httpClientFactory->create();
        $client->setUri('http://api.novaposhta.ua/v2.0/json/Address/getCities');
        $request = ['modelName' => 'Address', 'calledMethod' => 'getCities', 'apiKey' => $apiKey];
        $client->setConfig(['maxredirects' => 0, 'timeout' => 30]);
        $client->setRawData(utf8_encode(json_encode($request)));
        return $client->request(\Zend_Http_Client::POST)->getBody();
    }
}

