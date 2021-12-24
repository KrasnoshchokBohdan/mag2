<?php

namespace MageMastery\Blog\Controller\Blog;

use Magento\Framework\App\Action\Action;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\Result\Json;

class Index extends Action
{

    public function execute()
    {
        $page = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        return $page;
//        $jsonResult = $this->resultFactory->create(ResultFactory::TYPE_JSON);
//        $jsonResult->setData(['message'=>"First page"]);
//        return $jsonResult;
    }
}
