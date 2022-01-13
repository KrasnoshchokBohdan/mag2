<?php

namespace Instant\Purchase\Controller\Index;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Model\CustomerFactory;
use Magento\Customer\Model\Session;
use Magento\Framework\View\Result\PageFactory;
use Magento\Quote\Model\QuoteFactory;
use Magento\Quote\Model\QuoteManagement;
use Magento\Sales\Api\OrderManagementInterface;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Sales\Model\Order\Email\Sender\OrderSender;
use Magento\Store\Model\StoreManagerInterface;

class Index extends \Magento\Framework\App\Action\Action
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var OrderRepositoryInterface
     */
    protected $orderRepository;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var CustomerFactory
     */
    protected $customerFactory;

    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @var ProductRepositoryInterface
     */
    protected $customerRepository;

    /**
     * @var QuoteFactory
     */
    protected $quote;

    /**
     * @var QuoteManagement
     */
    protected $quoteManagement;

    /**
     * @var OrderSender
     */
    protected $orderSender;

    /**
     * @var OrderManagementInterface
     */
    protected $_order;

    /**
     * @var Registry
     */
    protected $registry;

    /**
     * @var Session
     */
    protected $customerSession;

    /**
     * @param PageFactory $resultPageFactory
     * @param OrderRepositoryInterface $orderRepository
     * @param StoreManagerInterface $storeManager
     * @param CustomerFactory $customerFactory
     * @param ProductRepositoryInterface $productRepository
     * @param CustomerRepositoryInterface $customerRepository
     * @param QuoteFactory $quote
     * @param QuoteManagement $quoteManagement
     * @param OrderSender $orderSender
     * @param OrderManagementInterface $orderManInterface
     * @param Registry $registry
     * @param Session $customerSession
     * @param Context $context
     */
    public function __construct(
        PageFactory                 $resultPageFactory,
        OrderRepositoryInterface    $orderRepository,
        StoreManagerInterface       $storeManager,
        CustomerFactory             $customerFactory,
        ProductRepositoryInterface  $productRepository,
        CustomerRepositoryInterface $customerRepository,
        QuoteFactory                $quote,
        QuoteManagement             $quoteManagement,
        OrderSender                 $orderSender,
        OrderManagementInterface    $orderManInterface,
        Registry                    $registry,
        Session                     $customerSession,
        Context                     $context

    )
    {
        $this->resultPageFactory = $resultPageFactory;
        $this->orderRepository = $orderRepository;
        $this->storeManager = $storeManager;
        $this->customerFactory = $customerFactory;
        $this->productRepository = $productRepository;
        $this->customerRepository = $customerRepository;
        $this->quote = $quote;
        $this->quoteManagement = $quoteManagement;
        $this->orderSender = $orderSender;
        $this->_order = $orderManInterface;
        $this->registry = $registry;
        $this->customerSession = $customerSession;
        parent::__construct($context);
    }

    public function execute()
    {
        $post = $this->getRequest()->getParams();
        $customerTel = $post['content']['0']['value'];
        $customerMail = $post['content']['3']['value'];
        $customerFirstName = $post['content']['1']['value'];
        $customerLastName = $post['content']['2']['value'];

        $productId = 0;  //$post['product']['0']['value'];
        $productQty = 0;  //$post['product']['5']['value'];
        $test1 = 0;
        $productItem = [
            [
                'product_id' => '70',
                'qty' => 2,
//                'super_attribute' => [
//                    93 => 52,
//                    142 => 167
//                ]
            ]
        ];

        foreach ($post['product'] as $item) {
            if ($item['name'] == 'product') {
                $productItem['product_id'] =  $item['value'];
            }
            if ($item['name'] == 'qty') {
                $productItem['qty'] = $item['value'];
            }
        }


        if ($test1 === 0) {
            return "";
        }

        $orderInfo = [
            'email' => $customerMail, //customer email id
            'currency_id' => 'USD',
            'address' => [
                'firstname' => $customerFirstName,
                'lastname' => $customerLastName,
                'prefix' => '',
                'suffix' => '',
                'street' => 'Test Street',
                'city' => 'Miami',
                'country_id' => 'US',
                'region' => 'Florida',
                'region_id' => '18', // State region id
                'postcode' => '98651',
                'telephone' => $customerTel,
                'fax' => '1234567890',
                'save_in_address_book' => 1
            ],
            'items' =>
                [
                    //simple product
                    [
                        'product_id' => $productId,
                        'qty' => $productQty
                    ],
                    //configurable product
//                    [
//                        'product_id' => '70',
//                        'qty' => 2,
//                        'super_attribute' => [
//                            93 => 52,
//                            142 => 167
//                        ]
//                    ]
                ]
        ];
        $store = $this->storeManager->getStore();
        $storeId = $store->getStoreId();
        $websiteId = $this->storeManager->getStore()->getWebsiteId();
        $customer = $this->customerFactory->create()
            ->setWebsiteId($websiteId)
            ->loadByEmail($orderInfo['email']); // Customer email address
        if (!$customer->getId()) {
            /**
             * If Guest customer, Create new customer
             */
            $customer->setStore($store)
                ->setFirstname($orderInfo['address'][$customerFirstName])
                ->setLastname($orderInfo['address'][$customerLastName])
                ->setEmail($orderInfo['email'])
                ->setPassword('admin@123');
            $customer->save();
        }
        $quote = $this->quote->create(); //Quote Object
        $quote->setStore($store); //set store for our quote

        /**
         * Registered Customer
         */
        $customer = $this->customerRepository->getById($customer->getId());
        $quote->setCurrency();
        $quote->assignCustomer($customer); //Assign Quote to Customer

        //Add Items in Quote Object
        foreach ($orderInfo['items'] as $item) {
            $product = $this->productRepository->getById($item['product_id']);
            if (!empty($item['super_attribute'])) {
                /**
                 * Configurable Product
                 */
                $buyRequest = new \Magento\Framework\DataObject($item);
                $quote->addProduct($product, $buyRequest);
            } else {
                /**
                 * Simple Product
                 */
                $quote->addProduct($product, intval($item['qty']));
            }
        }

        //Billing & Shipping Address to Quote
        $quote->getBillingAddress()->addData($orderInfo['address']);
        $quote->getShippingAddress()->addData($orderInfo['address']);

        // Set Shipping Method
        $shippingAddress = $quote->getShippingAddress();
        $shippingAddress->setCollectShippingRates(true)
            ->collectShippingRates()
            ->setShippingMethod('freeshipping_freeshipping'); //shipping method code, Make sure free shipping method is enabled
        $quote->setPaymentMethod('checkmo'); //Payment Method Code, Make sure checkmo payment method is enabled
        $quote->setInventoryProcessed(false);
        $quote->save();
        $quote->getPayment()->importData(['method' => 'checkmo']);

        try {
            // Collect Quote Totals & Save
            $quote->collectTotals()->save();

            // Create Order From Quote Object
            $order = $this->quoteManagement->submit($quote);

            $this->messageManager->addSuccess(__('Your order is completed. Thank you!'));
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            $this->messageManager->addError($e->getMessage());
        } catch (\RuntimeException $e) {
            $this->messageManager->addError($e->getMessage());
        } catch (\Exception $e) {
            $this->messageManager->addException($e, __('Something went wrong.'));
        }
    }
}



