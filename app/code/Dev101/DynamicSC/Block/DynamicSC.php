<?php

namespace Dev101\DynamicSC\Block;

class DynamicSC extends \Magento\Framework\View\Element\Template
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

    public function __construct(
        \Magento\Catalog\Block\Product\Context          $context,
        \Magento\Review\Block\Product\View              $product,
        \Dev101\DynamicSC\Helper\ModuleStatus           $moduleStatus,
        \Magento\Checkout\Model\CompositeConfigProvider $configProvider,
        array                                           $layoutProcessors = [],
        array                                           $data = []
    ) {
        $this->moduleStatus = $moduleStatus;
        $this->product = $product;
        $this->configProvider = $configProvider;
        $this->_layoutProcessors = $layoutProcessors;
        parent::__construct($context);
    }

    public function getJsLayout()
    {
        foreach ($this->_layoutProcessors as $processor) {
            $this->jsLayout = $processor->process($this->jsLayout);
        }

        return parent::getJsLayout();
    }

    public function isModuleEnabled()
    {
        return $this->moduleStatus->getModuleStatus();
    }
}
