<?php

namespace TestTasks\TaskOne\Cron;

class Test
{

    protected $_logger;
    protected $configWriter;
    protected $scopeConfig;

    public function __construct(
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\App\Config\Storage\WriterInterface $configWriter,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Framework\App\Cache\Frontend\Pool $cacheFrontendPool,
        \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList
    ) {
        $this->_logger = $logger;
        $this->configWriter = $configWriter;
        $this->_scopeConfig = $scopeConfig;
        $this->_cacheFrontendPool = $cacheFrontendPool;
        $this->_cacheTypeList = $cacheTypeList;
    }
    public function SetDataOn()
    {
        $path = 'taskone/general/cron_message_enable';
        $value = '1';

        $this->configWriter->save($path, $value, $scope = $this->_scopeConfig::SCOPE_TYPE_DEFAULT, $scopeId = 0);
    }

    public function SetDataOff()
    {
        $path = 'taskone/general/cron_message_enable';
        $value = '0';

        $this->configWriter->save($path, $value, $scope = $this->_scopeConfig::SCOPE_TYPE_DEFAULT, $scopeId = 0);
    }

    public function RuleOn()
    {
        $state = 1;
        //change price rule
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $catalogPriceRule = $objectManager->get('Magento\CatalogRule\Model\Rule')->load(2);
        $catalogPriceRule->setIsActive($state);
        $catalogPriceRule->save();

        //apply all catalog rules
        $ruleJob = $objectManager->get('Magento\CatalogRule\Model\Rule\Job');
        $ruleJob->applyAll();
    }

    public function RuleOff()
    {
        $state = 0;
        //change price rule
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $catalogPriceRule = $objectManager->get('Magento\CatalogRule\Model\Rule')->load(2);
        $catalogPriceRule->setIsActive($state);
        $catalogPriceRule->save();

        //apply all catalog rules
        $ruleJob = $objectManager->get('Magento\CatalogRule\Model\Rule\Job');
        $ruleJob->applyAll();
    }

    public function cacheClear()
    {
        /* get all types of cache in system */
        $allTypes = array_keys($this->_cacheTypeList->getTypes());
 
        /* Clean cached data for specific cache type */
        foreach ($allTypes as $type) {
            $this->_cacheTypeList->cleanType($type);
        }
 
        /* flushed the Entire cache storage from system, Works like Flush Cache Storage button click on System -> Cache Management */
        foreach ($this->_cacheFrontendPool as $cacheFrontend) {
            $cacheFrontend->getBackend()->clean();
        }
    }
}




