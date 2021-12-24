<?php

namespace Learning\CustomerAttribute2\Setup\Patch\Data;

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

class AddNewCustomerAttribute2 implements DataPatchInterface
{
    /** @var CustomerSetupFactory  */
    protected $customerSetupFactory;
    /** @var AttributeSetFactory  */
    private $attributeSetFactory;
    /** @var Config  */
    private $eavConfig;
    /** @var     */
    private $eavSetupFactory;

    public function __construct(
        EavSetupFactory $eavSetupFactory,
        CustomerSetupFactory $customerSetupFactory,
        AttributeSetFactory $attributeSetFactory,
        ModuleDataSetupInterface $setup
    ) {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->customerSetupFactory = $customerSetupFactory;
        $this->attributeSetFactory = $attributeSetFactory;
        $this->setup = $setup;
    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function apply()
    {
        // create your_sample_attribute1

        /** @var CustomerSetup $customerSetup */
        $customerSetup = $this->customerSetupFactory->create(['setup' => $this->setup]);
        $customerEntity = $customerSetup->getEavConfig()->getEntityType('customer');
        $attributeSetId = $customerEntity->getDefaultAttributeSetId();
        /** @var $attributeSet AttributeSet */
        $attributeSet = $this->attributeSetFactory->create();
        $attributeGroupId = $attributeSet->getDefaultGroupId($attributeSetId);

        $customerSetup->addAttribute(Customer::ENTITY, 'your_sample_attribute1', [
            'type' => 'int',
            'label' => 'Your Sample Attribute1',
            'input' => 'boolean',
            'required' => false,
            'visible' => true,
            'source' => '',
            'backend' => '',
            'user_defined' => false,
            'is_user_defined' => false,
            'sort_order' => 1000,
            'is_used_in_grid' => false,
            'is_visible_in_grid' => false,
            'is_filterable_in_grid' => false,
            'is_searchable_in_grid' => false,
            'position' => 1000,
            'default' => 0,
            'system' => 0,
        ]);
        $attribute = $customerSetup->getEavConfig()->getAttribute(Customer::ENTITY, 'your_sample_attribute1')
            ->addData([
                'attribute_set_id' => $attributeSetId,
                'attribute_group_id' => $attributeGroupId,
                'used_in_forms' => ['adminhtml_customer'],
            ]);
        $attribute->save();

        // create your_sample_attribute2

        /** @var CustomerSetup $customerSetup */
        $customerSetup = $this->customerSetupFactory->create(['setup' => $this->setup]);
        $customerEntity = $customerSetup->getEavConfig()->getEntityType('customer');
        $attributeSetId = $customerEntity->getDefaultAttributeSetId();
        /** @var $attributeSet AttributeSet */
        $attributeSet = $this->attributeSetFactory->create();
        $attributeGroupId = $attributeSet->getDefaultGroupId($attributeSetId);

        $customerSetup->addAttribute(Customer::ENTITY, 'your_sample_attribute2', [
            'type' => 'varchar',
            'label' => 'Your Sample Attribute2',
            'input' => 'multiselect',
            'required' => false,
            'visible' => true,
            'source' => 'Learning\CustomerAttribute2\Model\Entity\Attribute\Source\AvailableOptions',
            'backend' => '',
            'user_defined' => false,
            'is_user_defined' => false,
            'sort_order' => 1000,
            'is_used_in_grid' => false,
            'is_visible_in_grid' => false,
            'is_filterable_in_grid' => false,
            'is_searchable_in_grid' => false,
            'position' => 1000,
            'default' => 0,
            'system' => 0,
        ]);
        $attribute = $customerSetup->getEavConfig()->getAttribute(Customer::ENTITY, 'your_sample_attribute2')
            ->addData([
                'attribute_set_id' => $attributeSetId,
                'attribute_group_id' => $attributeGroupId,
                'used_in_forms' => ['adminhtml_customer'],
            ]);
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
