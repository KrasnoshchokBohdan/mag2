<?php

namespace City\Definition\Service;

use GuzzleHttp\Client;
use GuzzleHttp\ClientFactory;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\ResponseFactory;
use Magento\Framework\Webapi\Rest\Request;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\HTTP\PhpEnvironment\RemoteAddress;

/**
 * Class IpApiService get city from ip
 */
class IpApiService
{
    /**
     * @var Check
     */
    protected $check;
    /**
     * @var RemoteAddress;
     */
    private $remoteAddress;

    /**
     * API request URL
     */
    const API_REQUEST_URI = 'http://api.ipstack.com/';

    /**
     * Access key prefix
     */
    const API_REQUEST_KEY = '?access_key=';

    /**
     * prefix
     */
    const API_FORMAT_KEY = '&format=1';

    /**
     * patch
     */
    const CITY_PATCH = 'Глухов';

    /**
     * patch
     */
    const IP_PATCH = '5.180.100.0';

    /**
     * patch
     */
    const IP_PATCH_LANG = '&language=ru';

    /**
     * @var ResponseFactory
     */
    private $responseFactory;

    /**
     * @var ClientFactory
     */
    private $clientFactory;

    /**
     * @var Json
     */
    protected $serializer;

    /**
     * IpApiService constructor
     *
     * @param ClientFactory $clientFactory
     * @param ResponseFactory $responseFactory
     * @param Json $json
     * @param RemoteAddress $remoteAddress
     * @param Check $check
     */
    public function __construct(
        ClientFactory   $clientFactory,
        ResponseFactory $responseFactory,
        Json            $json,
        RemoteAddress   $remoteAddress,
        Check           $check
    ) {

        $this->remoteAddress = $remoteAddress;
        $this->serializer = $json;
        $this->clientFactory = $clientFactory;
        $this->responseFactory = $responseFactory;
        $this->check = $check;
    }

    /**
     * Fetch some data from API
     */
    public function execute()
    {
        $apiKey = $this->check->getIpStackKey();

        $ip = $this->remoteAddress->getRemoteAddress();
        if(!$ip || $ip == '127.0.0.1'){
            $ip = static::IP_PATCH;
        }

        $response = $this->doRequest($ip . static::API_REQUEST_KEY . $apiKey . static::IP_PATCH_LANG);  //  API_FORMAT_KEY
        $status = $response->getStatusCode();
        $responseBody = $response->getBody();
        $responseContent = $responseBody->getContents();
        return $responseContent;
    }

    /**
     * Do API request with provided params
     *
     * @param string $uriEndpoint
     * @param array $params
     * @param string $requestMethod
     *
     * @return Response
     */
    private function doRequest(
        string $uriEndpoint,
        array  $params = [],
        string $requestMethod = Request::HTTP_METHOD_GET
    ): Response {
        $client = $this->clientFactory->create(['config' => [
            'base_uri' => self::API_REQUEST_URI
        ]]);

        try {
            $response = $client->request(
                $requestMethod,
                $uriEndpoint,
                $params
            );
        } catch (GuzzleException $exception) {
            /** @var Response $response */
            $response = $this->responseFactory->create([
                'status' => $exception->getCode(),
                'reason' => $exception->getMessage()
            ]);
        }
        return $response;
    }

    /**
     * @return string
     *
     */
    public function sendCity()
    {
        $data = 0;
     //   $data = $this->serializer->unserialize($this->execute());
        if (!$data) {
            return static::CITY_PATCH;
        }
           return $data['city'];
    }
}
