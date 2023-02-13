<?php

use Magento\Framework\App\Bootstrap;

require __DIR__ . '/app/bootstrap.php';

$bootstrap = Bootstrap::create(BP, $_SERVER);

$om = $bootstrap->getObjectManager();
//$product = $om->get('\Perspective\IsRequestPrice\Service\LoadRequestService')->execute();




$subject = $om->get('\Magento\Catalog\Model\ProductRepository');
$product =  $om->create('\Magento\Catalog\Model\ProductRepository')->getById('1');
$test = $om->get('\ExtensionAttribute\Example\Plugin\ProductRepositoryInterface')->afterGet($subject, $product);
