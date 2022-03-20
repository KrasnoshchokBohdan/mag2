<?php

namespace Dev101\ProgramProduct\Setup;

use Magento\Eav\Setup\EavSetup;

use Magento\Framework\Setup\ModuleContextInterface;

use Magento\Framework\Setup\ModuleDataSetupInterface;

/**
 * @codeCoverageIgnore
 */
class UpgradeData implements \Magento\Framework\Setup\UpgradeDataInterface
{
    private $eavSetup;
    private $setup;
    private $eavSetupFactory;

    public function __construct(
        \Magento\Eav\Setup\EavSetup $eavSetup,
        \Magento\Eav\Setup\EavSetupFactory $eavSetupFactory,
        \Magento\Framework\Setup\ModuleDataSetupInterface $setup
    ) {
        $this->eavSetup = $eavSetup;
        $this->setup = $setup;

        $this->eavSetupFactory = $eavSetupFactory;
    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        if ($context->getVersion() && version_compare($context->getVersion(), '1.0.9') < 0) {

            /** @var EavSetup $eavSetup */

            $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);

            /**

            /**

             * Add attributes to the eav/attribute

             */

            $eavSetup->addAttributeGroup(
                \Magento\Catalog\Model\Product::ENTITY,
                4,
                'Blog Assigned Posts',
                3
            );
        }
    }
}
