<?php
namespace Dev101\DynamicSC\Plugin;

class Configurable
{
    /**
     * @var \Magento\Review\Block\Product\View
     */
    protected $product;
    /**
     * @var \Dev101\DynamicSC\Helper\ModuleStatus
     */
    protected $moduleStatus;
    /**
     * @var array
     */
    protected $_layoutProcessors;
    /**
     * @var \Magento\Checkout\Model\CompositeConfigProvider
     */
    protected $configProvider;
    /**
     * @var \Magento\Eav\Model\Config
     */
    protected $eavConfig;

    public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
        \Magento\Review\Block\Product\View $product,
        \Dev101\DynamicSC\Helper\ModuleStatus $moduleStatus,
        \Magento\Checkout\Model\CompositeConfigProvider $configProvider,
        \Magento\Eav\Model\Config $eavConfig,
        array $layoutProcessors = [],
        array $data = []
    ) {
        $this->moduleStatus = $moduleStatus;
        $this->product = $product;
        $this->configProvider = $configProvider;
        $this->_layoutProcessors = $layoutProcessors;
        $this->eavConfig = $eavConfig;
    }

    public function isModuleEnabled()
    {
        return $this->moduleStatus->getModuleStatus();
    }

    public function afterGetItemRenderer(\Magento\Checkout\Block\Cart\AbstractCart $subject, $result)
    {
        $attribute=$this->eavConfig->getAttribute('catalog_product', 'size');
        $options = $attribute->getSource()->getAllOptions();
        $result->setTemplate('Dev101_DynamicSC::cart/item/custom.phtml');

        return $result;
    }
}
