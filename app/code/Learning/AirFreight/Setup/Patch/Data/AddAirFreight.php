<?php

namespace Learning\AirFreight\Setup\Patch\Data;

use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class AddAirFreight implements DataPatchInterface
{
    /** @var ModuleDataSetupInterface */
    private $moduleDataSetup;
    /** @var EavSetupFactory */
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
        /** @var EavSetup $eavSetup */
        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);
        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'air_freight',
            [
                'group' => 'General',
                'type' => 'varchar',
                'label' => 'Air Freight Only',
                'input' => 'select',
                'source' =>
                'Learning\AirFreight\Model\Attribute\Source\Vehicle',
                'frontend' =>
                'Learning\AirFreight\Model\Attribute\Frontend\Vehicle',
                'backend' => 'Learning\AirFreight\Model\Attribute\Backend\Vehicle',
                'required' => false,
                'sort_order' => 50,
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                'is_used_in_grid' => false,
                'is_visible_in_grid' => false,
                'is_filterable_in_grid' => false,
                'visible' => true,
                'is_html_allowed_on_front' => true,
                'visible_on_front' => true

            ]
        );
    } 

    /**
     * {@inheritdoc}
     */
    public static function getDependencies()
    {
        return [];
    }


    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return [];
    }
}
