<?php
namespace Dev101\DynamicSC\Helper;

use Magento\Framework\App\Helper\Context;

class ModuleStatus extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;
    /**
     * @var \Magento\Framework\App\Config\Storage\WriterInterface
     */
    protected $configWriter;

    public function __construct(
        Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Framework\App\Config\Storage\WriterInterface $configWriter
    ) {
        $this->scopeConfig= $scopeConfig;
        $this->configWriter= $configWriter;
        parent::__construct($context);
    }

    public function getModuleStatus()
    {
        $moduleStatus=$this->scopeConfig->getValue('DynamicSCSection/DynamicSCGroup/DynamicSCModuleStatus');
        if ($moduleStatus==1) {
            /**
             * Save config value to storage
             *
             * @param string $path
             * @param string $value
             * @param string $scope
             * @param int $scopeId
             * @return void
             */
            $pathGrouped='checkout/cart/grouped_product_image';
            $pathScoped='checkout/cart/configurable_product_image';
            $getConfigGroupedProductThumbnailItself=$this->scopeConfig->getValue($pathGrouped);
            $getConfigConfigurableProductThumbnailItself=$this->scopeConfig->getValue($pathScoped);
            $newValueGrouped='itself';
            $newValueConfigurable='itself';
            $setConfigGroupedProductThumbnailItself=$this->configWriter->save($pathGrouped,$newValueGrouped,'default',0);
            $setConfigConfigurableProductThumbnailItself=$this->configWriter->save($pathScoped,$newValueConfigurable,'default',0);
            return true;
        } else {
            return false;
        }
    }



}
