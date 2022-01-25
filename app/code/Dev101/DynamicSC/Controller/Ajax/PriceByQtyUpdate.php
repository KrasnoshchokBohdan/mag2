<?php

namespace Dev101\DynamicSC\Controller\Ajax;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;

class PriceByQtyUpdate extends Action
{

    /**
     * @var \Magento\Checkout\Model\Session
     */
    protected $checkoutSession;
    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     *
     */
    protected $resultJsonFactory;
    /**
     * @var \Magento\Catalog\Model\ProductRepository
     */
    protected $productRepository;
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    public function __construct(
        Context $context,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Magento\Catalog\Model\ProductRepository $productRepository,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        $this->checkoutSession = $checkoutSession;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->productRepository = $productRepository;
        $this->storeManager = $storeManager;
        parent::__construct($context);
    }

    public function execute()
    {
        $request = $this->getRequest();
        $params=$request->getParams();
        if ($request->isAjax()) {
            $session=$this->checkoutSession->getQuote();
            $getItems=$session->getItems();
            $itemId=$params['item'];
            $item=$session->getItemById($itemId);
            $currentProduct= $item->getProduct();

            $data = $currentProduct->getTypeInstance()->getConfigurableOptions($currentProduct);

            $options = [];
            foreach ($data as $code => $attr) {
                $options[$code]=$attr;
                $super_attribute[$code]=[];
                foreach ($options[$code] as $product) {
                    if (($product['attribute_code']=='size') and ($product['option_title']==$params['size'])) {
                        $super_attribute[$code]=$product['value_index'];
                    }
                    if (($product['attribute_code']=='color') and ($product['option_title']==$params['color'])) {
                        $super_attribute[$code]=$product['value_index'];
                    }
                }
            }


            $answer = $super_attribute;
            $result = $this->resultJsonFactory->create();
            $result->setData($answer);

            return $result;
        }

        $text = "Error 404 page Wrong Call";
        echo $text;
        exit;
    }
}
