<?php
namespace Perspective\OrderCollectionWithFilters\Block;
class Index extends \Magento\Framework\View\Element\Template
{
    private $data;
    private $context;
    private $orderCollectionFactory;

 public function __construct(\Magento\Backend\Block\Template\Context $context,
  \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $orderCollectionFactory,
  array $data = []

    ) {
        $this->orderCollectionFactory = $orderCollectionFactory;
        //$this->logger = $logger;
        parent::__construct($context, $data);
    }
 
    public function getCustomerOrder()
    {
        $customerId = 2; // pass customer id
        $customerOrder = $this->orderCollectionFactory->create()
            ->addFieldToFilter('customer_id', $customerId);
        return $customerOrder->getData();
    }
}
