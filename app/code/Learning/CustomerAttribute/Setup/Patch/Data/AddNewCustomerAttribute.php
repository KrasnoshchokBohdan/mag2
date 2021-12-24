<?php

namespace Learning\CustomerAttribute\Setup\Patch\Data;

use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

use Magento\Customer\Setup\CustomerSetup;
use Magento\Eav\Model\Entity\Attribute\Source\Boolean;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Customer\Model\Customer;
use Magento\Eav\Model\Entity\Attribute\Set as AttributeSet;
use Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;

class AddNewCustomerAttribute implements DataPatchInterface
{
    /** @var ModuleDataSetupInterface */
    private $moduleDataSetup;
    /** @var EavSetupFactory */
    private $eavSetupFactory;

    /** @var CustomerSetupFactory */
    private $_customerSetupFactory;
    /** @var AttributeSetFactory */
    private $_attributeSetFactory;
    /** @var   ModuleDataSetupInterface */
    private $_setup;
    /** @var ModuleContextInterface */
   // private $_context;


    /**
     * Init
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param EavSetupFactory $eavSetupFactory
     
     * @param CustomerSetupFactory $customerSetupFactory
     * @param AttributeSetFactory $attributeSetFactory
     * @param ModuleDataSetupInterface $setup,
     * @param ModuleContextInterface $context
     */
    public function __construct(
        CustomerSetupFactory $customerSetupFactory,
        AttributeSetFactory $attributeSetFactory,
        ModuleDataSetupInterface $setup,
      //ModuleContextInterface $context,

        ModuleDataSetupInterface $moduleDataSetup,
        EavSetupFactory $eavSetupFactory
    ) {
        $this->_customerSetupFactory = $customerSetupFactory;
        $this->_attributeSetFactory = $attributeSetFactory;
        $this->_setup = $setup;
     // $this->_context = $context;

        $this->moduleDataSetup = $moduleDataSetup;
        $this->eavSetupFactory = $eavSetupFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function apply()
    {

        /** @var CustomerSetup $customerSetup */
        $customerSetup = $this->_customerSetupFactory->create(['setup' => $this->_setup]);
        $customerEntity = $customerSetup->getEavConfig()->getEntityType('customer');
        $attributeSetId = $customerEntity->getDefaultAttributeSetId();

        /** @var $attributeSet AttributeSet */
        $attributeSet = $this->_attributeSetFactory->create();
        $attributeGroupId = $attributeSet->getDefaultGroupId($attributeSetId);

        $customerSetup->addAttribute(Customer::ENTITY,'enabled',  [
                'type' => 'int',
                'label' => 'Enabled',
                'input' => 'select',
                'required' => false,
                'visible' => true,
                'user_defined' => true,
                'sort_order' => 600,
                'position' => 600,
                'is_used_in_grid' => true,
                'is_visible_in_grid' => true,
                'is_filterable_in_grid' => true,
                'is_searchable_in_grid' => true,
                'system' => false,
                'source' => Boolean::class,
                'adminhtml_only' => 1,
                'default' => 1,
                'unique' => false,
                'frontend_input' => 'select',
            ]
        );
        $attribute = $customerSetup->getEavConfig()->getAttribute(Customer::ENTITY, 'enabled')
            ->addData(
                [
                    'attribute_set_id' => $attributeSetId,
                    'attribute_group_id' => $attributeGroupId,
                    'used_in_forms' => ['adminhtml_customer'],
                ]
            );
        $attribute->save();
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
