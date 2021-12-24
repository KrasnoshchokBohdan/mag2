<?php

namespace CodeEditing\Demo\Plugins;

use \Magento\Catalog\Model\Product;

class SomeProduct
{
    public function beforeSetName(Product $subject, $name)
    {
        return ['(' . $name . ')'];
    }

    public function afterGetName(Product $subject, $result)
    {
       return '|' . $result . '|';
    }

    public function aroundSave(Product $subject, callable $proceed, $arg1, $arg2)
    {
         if ($arg1 && $subject->someTerm()){
            return $proceed($arg1, $arg2);
         }
         return null;
    }
}