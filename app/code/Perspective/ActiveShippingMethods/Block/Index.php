<?php
namespace Perspective\ActiveShippingMethods\Block;
class Index extends \Magento\Framework\View\Element\Template
{
	protected $scopeConfig; 
	protected $shipconfig;
	
	public function __construct(
		\Magento\Backend\Block\Template\Context $context,
	\Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
	\Magento\Shipping\Model\Config $shipconfig,
	array $data = []
	) {
		$this->shipconfig = $shipconfig;
		$this->scopeConfig = $scopeConfig;
		parent::__construct($context, $data);
	}
	
	public function getShippingMethods() {
		$activeCarriers = $this->shipconfig->getActiveCarriers();
	
		foreach($activeCarriers as $carrierCode => $carrierModel) {
		   $options = array();
	
		   if ($carrierMethods = $carrierModel->getAllowedMethods()) {
			   foreach ($carrierMethods as $methodCode => $method) {
					$code = $carrierCode . '_' . $methodCode;
					$options[] = array('value' => $code, 'label' => $method);
			   }
			   $carrierTitle = $this->scopeConfig
				   ->getValue('carriers/'.$carrierCode.'/title');
			}
	
			$methods[] = array('value' => $options, 'label' => $carrierTitle);
		}
	
		return $methods;    
	}
}
