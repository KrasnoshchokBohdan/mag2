<?php

namespace Perspective\ProductByID\Controller\Index;

use \Magento\Framework\App\ActionInterface;
use Magento\Framework\Controller\ResultFactory;
class Index extends \Magento\Framework\App\Action\Action
{
    public function execute()
    {
              $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
       return $resultPage;
    }
}
