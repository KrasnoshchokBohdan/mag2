<?php
namespace Perspective\ListOfAllCustomers\Block;
class Index extends \Magento\Framework\View\Element\Template
{
protected $_customerFactory;
    
public function __construct(
 \Magento\Backend\Block\Template\Context $context,
 \Magento\Customer\Model\CustomerFactory $customerFactory,
 array $data = []
) 
{
 $this->_customerFactory = $customerFactory;
 parent::__construct($context, $data);
}
 
public function getCustomerCollection() 
{
 $collection = $this->_customerFactory->create()->getCollection()
 ->addAttributeToSelect("*")
 ->load();
 return $collection;
}
}