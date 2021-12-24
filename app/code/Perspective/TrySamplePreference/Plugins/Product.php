<?php 

namespace Perspective\TrySamplePreference\Plugins;

class Product 
{
/*    
public function afterGetName(\Magento\Catalog\Model\Product $product, $name) 
{ 
     $price = $product->getData('price');
     if ($price <60){
          $name .=' Так дешево!';
     } else{
          $name .=' Очень дорого!';

     }

     return $name;
} 
*/

public function afterGetPrice(\Magento\Catalog\Model\Product $product, $price) 
{ 
     
   $price +=100;

     return $price;
 } 


}
