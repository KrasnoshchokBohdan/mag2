<?php

namespace Dev101\DynamicSC\ViewModel;

use Magento\Framework\DataObject;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class CustomItem extends DataObject implements ArgumentInterface
{
    /**
     * @var \Magento\Review\Block\Product\View
     */
    protected $product;
    /**
     * @var \Magento\Catalog\Block\Product\Context
     */
    protected $context;
    /**
     * @var \Dev101\DynamicSC\Helper\ModuleStatus
     */
    protected $moduleStatus;

    /**
     * @var \Magento\Checkout\Model\CompositeConfigProvider
     */
    protected $configProvider;
    /**
     * @var \Magento\Eav\Model\Config
     */
    protected $eavConfig;
    /**
     * @var \Magento\Catalog\Model\ProductRepository
     */
    protected $productRepository;
    /**
     * @var \Magento\Checkout\Block\Cart\Item\Renderer
     */
    protected $item;
    /**
     * @var \Magento\Catalog\Model\Product\Configuration\Item\ItemResolverInterface
     */
    protected $itemResolver;
    /**
     * @var \Magento\Checkout\Model\Session
     */
    protected $session;
    /**
     * @var \Magento\Catalog\Model\Product\Option
     */
    protected $option;

    public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
        \Magento\Review\Block\Product\View $product,
        \Dev101\DynamicSC\Helper\ModuleStatus $moduleStatus,
        \Magento\Checkout\Model\CompositeConfigProvider $configProvider,
        \Magento\Eav\Model\Config $eavConfig,
        \Magento\Catalog\Model\ProductRepository $productRepository,
        \Magento\Checkout\Block\Cart\Item\Renderer $item,
        \Magento\Checkout\Model\Session $session,
        \Magento\Catalog\Model\Product\Option $option,
        array $data = []
    ) {
        $this->context = $context;
        $this->moduleStatus = $moduleStatus;
        $this->product = $product;
        $this->configProvider = $configProvider;
        $this->eavConfig = $eavConfig;
        $this->productRepository = $productRepository;
        $this->item = $item;
        $this->session = $session;
        $this->option = $option;
        parent::__construct();
    }

    public function isModuleEnabled()
    {
        return $this->moduleStatus->getModuleStatus();
    }

    public function getItems()
    {
        return $this->item->getItem();
    }

    public function getCurrentProduct()
    {
        $session=$this->session->getQuote();
        $getItems=$session->getItems();
        $itemId=$getItems[0]->getData('item_id');
        $item=$session->getItemById($itemId);
        $currentProduct= $item->getProduct();

        return $currentProduct;
    }
    public function getCustomOptions($product)
    {
        $currentProduct=$product;
        $data = $currentProduct->getTypeInstance()->getConfigurableOptions($currentProduct);

        $options = [];
        $i=0;
        foreach ($data as $attr) {
            $options[$i]=$attr;
            foreach ($options[$i] as $product) {
                $value[$i]='Select ' . $product['attribute_code'];
            }
            $i++;
        }

        return $value;
    }

    public function getCustomValues($product)
    {
        $currentProduct=$product;
        $data = $currentProduct->getTypeInstance()->getConfigurableOptions($currentProduct);

        $attributes=[];
        $num=0;
        $i=0;
        foreach ($data as $attr=>$key) {
            $attributes[$i]=$data[$attr];
            foreach ($attributes[$i] as $product) {
                $value[$i][$num]=$product['option_title'];
                $num++;
                $values[$i]=array_unique($value[$i]);
            }
            $i++;
        }
        return $values;
    }

    public function getProductId($product)
    {
        $currentProduct=$product;
        $data = $currentProduct->getTypeInstance()->getConfigurableOptions($currentProduct);

        foreach ($data as $attr) {
            foreach ($attr as $product) {
                $value[]=$product['product_id'];
            }
        }
        $product=array_unique($value);

        return $product;
    }

}

/**     foreach ($data as $attr) {
foreach ($attr as $p) {
$options[$p['sku']][$p['attribute_code']] = $p['option_title'];
}
}

foreach ($options as $sku =>$d) {
$pr = $currentProduct;
foreach ($d as $k => $v) {
echo $k . ' - ' . $v . ' ';
}
echo ' : ' . $pr->getPrice() . "\n";
} */
