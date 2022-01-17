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
//use Magento\Tests\NamingConvention\true\string;

/**
 * Class GitApiService
 */
class GitApiService
{
    /**
     * @var RemoteAddress;
     */
    private $remoteAddress;

    /**
     * API request URL
     */
    const API_REQUEST_URI = 'http://api.ipstack.com/';

    //const API_REQUEST_URI = 'https://api.github.com/';
    // const API_REQUEST_ENDPOINT = 'repos/';

    /**
     * Access key
     */
    const API_REQUEST_KEY = '?access_key=8c8006b798728ba8ae135d47405bc26f&format=1';

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
     * GitApiService constructor
     *
     * @param ClientFactory $clientFactory
     * @param ResponseFactory $responseFactory
     * @param Json $json
     * @param RemoteAddress $remoteAddress
     */
    public function __construct(
        ClientFactory   $clientFactory,
        ResponseFactory $responseFactory,
        Json            $json,
        RemoteAddress   $remoteAddress

    ) {
        $this->remoteAddress = $remoteAddress;
        $this->serializer = $json;
        $this->clientFactory = $clientFactory;
        $this->responseFactory = $responseFactory;
    }

    /**
     * Fetch some data from API
     */
    public function execute()
    {
        // $repositoryName = 'magento/magento2';
        // $response = $this->doRequest(static::API_REQUEST_ENDPOINT . $repositoryName); //  repos/magento/magento2

        $ip = $this->remoteAddress->getRemoteAddress();
        $ip = '92.113.171.50';
        $response = $this->doRequest($ip . static::API_REQUEST_KEY);  //'92.113.171.50?access_key=8c8006b798728ba8ae135d47405bc26f&format=1'
        $status = $response->getStatusCode(); // 200 status code
        $responseBody = $response->getBody();
        $responseContent = $responseBody->getContents(); // here you will have the API response in JSON format
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
            'base_uri' => self::API_REQUEST_URI                //   https://api.github.com/
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

    public function sendCity()
    {
        $data = $this->serializer->unserialize($this->execute());
        return $data['city'];
    }
}

