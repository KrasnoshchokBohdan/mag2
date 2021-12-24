<?php

namespace AdminACL\RunOut\ViewModel;

class CustomViewModel implements \Magento\Framework\View\Element\Block\ArgumentInterface
{
  protected $stockItemRepository;
  protected $registry;
  protected $helperData;

  public function __construct(
    \Learning\SocialAttribute\Helper\Data $helperData,
    \Magento\CatalogInventory\Api\StockItemRepositoryInterface $stockItemRepository,
    \Magento\Framework\Registry  $registry
  ) {
    $this->stockItemRepository = $stockItemRepository;
    $this->registry = $registry;
    $this->helperData = $helperData;
  }


  public function getHello()
  {

    return 'hello1';
  }
}
