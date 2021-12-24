<?php

namespace Perspective\ProductCurrentCategory\Block;

class Index extends \Magento\Framework\View\Element\Template
{
    protected $_categoryCollectionFactory;
    protected $_productRepository;
    private $layerResolver;
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory
        $categoryCollectionFactory,
        \Magento\Catalog\Model\ProductRepository $productRepository,
        \Magento\Catalog\Model\Layer\Resolver $layerResolver,
        array $data = []
    ) {
        $this->_categoryCollectionFactory = $categoryCollectionFactory;
        $this->_productRepository = $productRepository;
        $this->layerResolver = $layerResolver;
        parent::__construct($context, $data);
    }
    public function _prepareLayout()
    {
        return parent::_prepareLayout();
    }
    public function getCurrentCategory()
    {
        return $this->layerResolver->get()->getCurrentCategory();
    }
    public function getCurrentCategoryId()
    {
        return $this->getCurrentCategory()->getId();
    }
    public function getProductById($id)
    {
        return $this->_productRepository->getById($id);
    }
}
