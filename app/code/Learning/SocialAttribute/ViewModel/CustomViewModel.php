<?php

namespace Learning\SocialAttribute\ViewModel;

class CustomViewModel implements \Magento\Framework\View\Element\Block\ArgumentInterface
{
  protected $helperData;
  protected $productRepository;

  public function __construct(
    \Learning\SocialAttribute\Helper\Data $helperData,
    \Magento\Catalog\Model\ProductRepository $productRepository
  ) {
    $this->helperData = $helperData;
    $this->_productRepository = $productRepository;
  }

  /**
   * 
   * @return str
   */
  public function getSocial($_product)
  {
    if ($this->helperData->getGeneralConfig('enable')) {
      $currentProduct = $this->_productRepository->getById($_product->getData('entity_id'));
      if ($currentProduct->getData('social_attribute')) {
        return '<b>SOCIAL</b>';
      }
    }
  }
}
