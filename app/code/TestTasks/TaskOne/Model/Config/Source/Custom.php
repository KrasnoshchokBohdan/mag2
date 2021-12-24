<?php

namespace TestTasks\TaskOne\Model\Config\Source;

class Custom extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{
    protected $_storeManager;

    public function __construct(\Magento\Store\Model\StoreManagerInterface $storeManager)
    {
        $this->_storeManager = $storeManager;
    }
    /**
     * Get all options
     * @return array
     */
    public function getAllOptions()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $categoryFactory = $objectManager->create('Magento\Catalog\Model\ResourceModel\Category\CollectionFactory');
        $categories = $categoryFactory->create()->addAttributeToSelect('*')->setStore($this->_storeManager->getStore());

        foreach ($categories as $category) {
            $this->_options[] =
                ['label' => __($category->getName() . '(ID:' . $category->getEntityId() . ')'), 'value' => $category->getEntityId()];
        }
        return $this->_options;
    }
}
