<?php
//declare (strict_types = 1);
//namespace MagentoTest\Test\Controller\Index;
//use Magento\Framework\App\ActionInterface;
//class Testtext implements ActionInterface
//{
//public function execute()
//{
//die("Controller 1");
//}
//}

namespace MagentoTest\Test\Controller\Index;
use Magento\Framework\App\Action\Action;
class Testtext extends Action
{
    public function execute(){ 
        die("Controller1_1");
     }
}
?>