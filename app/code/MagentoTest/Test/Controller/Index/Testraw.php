<?php
declare(strict_types=1);
namespace MagentoTest\Test\Controller\Index;
//namespace Perspective\HelloWorld\Controller\Index;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\Controller\Result\RawFactory;
/**
Class Testraw
@package Perspective\HelloWorld\Controller\Index
*/
class Testraw implements ActionInterface{
/***
@var RawFactory
*/
protected $resultFactory;
/**
* Index constructor.
*
* @param RawFactory $resultFactory
*/
public function __construct(RawFactory $resultFactory)
{
$this->resultFactory = $resultFactory;
}
//public function execute()
//{
//$page = $this->resultFactory->create()
//->setContents("<i>Perspective Studio</i>");
//return $page;
//}
public function execute()
{
$page = $this->resultFactory->create()
->setHeader('Content-Type', 'text/xml')
->setContents("<root><name>Perspective Studio</name><job>Magento Developer</job></root>");
}
}