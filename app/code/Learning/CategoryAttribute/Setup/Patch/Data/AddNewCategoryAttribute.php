<?php

namespace Learning\CategoryAttribute\Setup\Patch\Data;

use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;


use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;


class AddNewCategoryAttribute implements DataPatchInterface
{

    /** @var EavSetupFactory */
    private $eavSetupFactory;
    /** @var   ModuleDataSetupInterface */
    private $_setup;

    /**
     * Init
     * @param EavSetupFactory $eavSetupFactory
     * @param ModuleDataSetupInterface $setup,
     * @param ModuleDataSetupInterface $setup,
     */
    public function __construct(
        EavSetupFactory $eavSetupFactory,
        ModuleDataSetupInterface $setup

    ) {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->_setup = $setup;
    }

    /**
     * {@inheritdoc}
     */
    public function apply()
    {

        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->_setup]);

    
		$eavSetup->addAttribute(
			\Magento\Catalog\Model\Category::ENTITY,
			'mp_new_attribute',
			[
				'type'         => 'varchar',
				'label'        => 'Mageplaza Attribute',
				'input'        => 'text',
				'sort_order'   => 100,
				'source'       => '',
				'global'       => 1,
				'visible'      => true,
				'required'     => false,
				'user_defined' => false,
				'default'      => null,
				'group'        => '',
				'backend'      => ''
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
