<?php
namespace AdminACL\HelloWorld\Block;
class Index extends \Magento\Framework\View\Element\Template
{
	protected $_productRepository;
		
	public function __construct(
		\Magento\Backend\Block\Template\Context $context,		
		array $data = []
	)
	{
		parent::__construct($context, $data);
	}
	
	/**
       * 
       * @return str
       *  */
	public function getHello()
	{
		return "hello";
	}

}
