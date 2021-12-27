<?php

namespace Perspective\CustomerAvatar\Setup\Patch\Data;

use Magento\Customer\Model\Customer;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class ProfilePictureAttribute implements DataPatchInterface
{
    /**
     * @var CustomerSetupFactory
     */
    private $customerSetupFactory;
    /**
     * @var AttributeSetFactory
     */
    private $attributeSetFactory;
    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @param CustomerSetupFactory $customerSetupFactory
     * @param AttributeSetFactory $attributeSetFactory
     * @param ModuleDataSetupInterface $moduleDataSetup
     */
    public function __construct(
        CustomerSetupFactory $customerSetupFactory,
        AttributeSetFactory $attributeSetFactory,
        ModuleDataSetupInterface $moduleDataSetup
    ) {
        $this->customerSetupFactory = $customerSetupFactory;
        $this->attributeSetFactory = $attributeSetFactory;
        $this->moduleDataSetup = $moduleDataSetup;
    }

    /**
     * {@inheritdoc}
     */
    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $setup = $this->moduleDataSetup;

        $customerSetup = $this->customerSetupFactory->create(['setup' => $setup]);

        $customerEntity = $customerSetup->getEavConfig()->getEntityType('customer');
        $attributeSetId = $customerEntity->getDefaultAttributeSetId();

        $attributeSet = $this->attributeSetFactory->create();
        $attributeGroupId = $attributeSet->getDefaultGroupId($attributeSetId);

        $attributeCode = 'profile_picture';

        $customerSetup->addAttribute(Customer::ENTITY, $attributeCode, [
            'type' => 'text',
            'label' => 'Profile Picture',
            'input' => 'image',
            'required' => false,
            'visible' => true,
            'user_defined' => true,
            'sort_order' => 10,
            'position' => 10,
            'system' => 0,
            'is_used_in_grid' => true,
            'is_visible_in_grid' => true,
            'is_html_allowed_on_front' => true,
            'visible_on_front' => true,
            'backend' => '',
            'source' => ''
        ]);

        $attribute = $customerSetup->getEavConfig()
            ->getAttribute(Customer::ENTITY, $attributeCode)
            ->addData([
                'attribute_set_id' => $attributeSetId,
                'attribute_group_id' => $attributeGroupId,
                'used_in_forms' => ['adminhtml_customer', 'customer_account_edit'],
            ]);

        $attribute->save();

        $this->moduleDataSetup->getConnection()->endSetup();
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
