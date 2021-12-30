<?php
declare(strict_types=1);

namespace Attribute\CustomPrice\Setup\Patch\Data;

use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\Product\Attribute\Backend\Boolean;
use Magento\Catalog\Model\Product\Attribute\Backend\Price;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

/**
 * Class for set up the attribute
 */
class CustomPriceAttribute implements DataPatchInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        EavSetupFactory $eavSetupFactory
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->eavSetupFactory = $eavSetupFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function apply()
    {
        $eavCustomAttribute = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);

        $eavCustomAttribute->addAttribute(
            Product::ENTITY,
            'custom_price_attribute',
            [
                'group' => 'General',
                'type' => 'decimal',
                'source' => '',
                'input' => 'price',
                'frontend' => '',
                'backend' => Price::class,
                'required' => false,
                'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                'default' => '',
                'sort_order' => 30,
                'visible' => true,
                'filterable' => true,
                'searchable' => true,
                'user_defined' => true,
                'is_used_in_grid' => true,
                'is_visible_in_grid' => false,
                'is_filterable_in_grid' => true,
                'is_html_allowed_on_front' => true,
                'used_in_product_listing' => true,
                'visible_on_front' => true,
                'visible_in_advanced_search' => true
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public static function getDependencies()
    {
        return [];
    }
}
