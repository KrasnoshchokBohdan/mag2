<?php

namespace Learning\Currency\Controller\Index;

use Magento\Framework\App\Action\Context;
use Learning\Currency\Helper\Data;

class Config extends \Magento\Framework\App\Action\Action
{

    protected $helperData;

    public function __construct(
        Context $context,
        Data $helperData

    )
    {
        $this->helperData = $helperData;
        return parent::__construct($context);
    }

    public function execute()
    {

        // TODO: Implement execute() method.

        echo $this->helperData->getGeneralConfig('enable');
        echo $this->helperData->getGeneralConfig('display_text');
        echo '<hr>';
        echo $this->helperData->getGeneralConfig('uah_enable');
        echo $this->helperData->getGeneralConfig('uah_ex_rate');
        echo '<hr>';
        echo $this->helperData->getGeneralConfig('rub_enable');
        echo $this->helperData->getGeneralConfig('rub_ex_rate');
        echo '<hr>';
        echo $this->helperData->getGeneralConfig('euro_enable');
        echo $this->helperData->getGeneralConfig('euro_ex_rate');
        exit();

    }
}
