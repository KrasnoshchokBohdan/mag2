<?php

namespace Checkout\InternationalDelivery\Controller\Index;

use Magento\Checkout\Model\Session;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Json\Helper\Data;
use Magento\Framework\View\Result\PageFactory;
use Psr\Log\LoggerInterface;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\App\Response\Http;

class Index extends \Magento\Framework\App\Action\Action    //\Magento\Framework\App\Action\HttpPostActionInterface
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var Data
     */
    protected $jsonHelper;

    /**
     * @var Session
     */
    private $checkoutSession;

    /**
     * @var Json
     */
    //  protected $serializer;

    /**
     * @var Http
     */
    //   protected $http;

    // protected  $context;

    /**
     * Constructor
     *
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param Data $jsonHelper
     * @param LoggerInterface $logger
     * @param Session $checkoutSession
     */
    public function __construct(
        Context         $context,
        PageFactory     $resultPageFactory,
        Data            $jsonHelper,
        //    Json $json,
        //   Http $http,
        LoggerInterface $logger,
        Session         $checkoutSession
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->jsonHelper = $jsonHelper;
        //     $this->serializer = $json;
        //     $this->http = $http;
        $this->logger = $logger;
        parent::__construct($context);
        $this->checkoutSession = $checkoutSession;
        //   $this->context = $context;
    }

    /**
     * Execute view action
     *
     * @return ResultInterface
     */
    public function execute()
    {

        try {
            $items = $this->checkoutSession->getQuote()->getAllVisibleItems();
            $result = [
                'success' => false,
                'items' => []
            ];

            foreach ($items as $item) {
                $test = $item->getWeight();
                if (!$item->getWeight()) {
                    $result['success'] = true;
                    $result['items'][] = $item->getName();
                }
            }
            return $this->jsonResponse($result);
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            $result = [
                'success' => false,
                'message' => $e->getMessage()
            ];
            return $this->jsonResponse($result);
        } catch (\Exception $e) {
            $this->logger->critical($e);
            $result = [
                'success' => false,
                'message' => $e->getMessage()
            ];
            return $this->jsonResponse($result);
        }
    }

    /**
     * Create json response
     *
     * @return //ResultInterface
     */
    public function jsonResponse($response = '')
    {
        return $this->getResponse()->representJson(
            $this->jsonHelper->jsonEncode($response)
        );
    }

    /**    {
     * $this->http->getHeaders()->clearHeaders();
     * $this->http->setHeader('Content-Type', 'application/json');
     * return $this->http->setBody(
     * $this->serializer->serialize($response)
     * );
     * }  */
}
