<?php
namespace Perspective\TaskBd\Block;

class Category extends \Magento\Framework\View\Element\Template
{
    protected $postCollectionFactory;
    protected $productRepository;
    protected $productImageHelper;
    protected $registry;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Perspective\TaskBd\Model\ResourceModel\Post\CollectionFactory $postCollectionFactory,
        \Magento\Catalog\Model\ProductRepository $productRepository,
		\Magento\Catalog\Helper\Image $productImageHelper,
        \Magento\Framework\Registry $registry,
        array $data = []
    ) {

        $this->postCollectionFactory = $postCollectionFactory;
        $this->productRepository = $productRepository;
		$this->productImageHelper= $productImageHelper;
        $this->registry = $registry;
        parent::__construct($context, $data);
    }
 
     /**
       * 111
       * @return \Perspective\TaskBd\Model\ResourceModel\Post\Collection;
       *  */
    public function getPostCollectionForCategory() {
        $category = 14;
        $post = $this->postCollectionFactory->create();
        $post->addFieldToSelect('*')->addFieldToFilter('IDCat',['in'=>[$category]]);
        return $post;
    }
    /**
       * 222
       * @return \Magento\Catalog\Model\Product;
       *  */
    public function getProductById($id)
    {
        return $this->productRepository->getById($id);
    }

    /**
       * 333
       * @return URL;
       *  */
    public function getProductImageUrl($product, $imageId, $attributes = [])
    {
        return $this->productImageHelper->init($product, $imageId, $attributes)->getUrl();
    }   

           /**
       * Additionally:Place review information under the product in the new Review tab
       * @return \Perspective\TaskBd\Model\ResourceModel\Post\Collection;
       *  */
      public function getPostCollectionForProductId($id) {
        $post = $this->postCollectionFactory->create();
        $post->addFieldToSelect('*')->addFieldToFilter('IDProd',['eq'=>$id]);
        return $post;
    }
         /**
       * Additionally:Place review information under the product in the new Review tab
       * @return current_product;
       *  */
      public function getCurrentProduct()
      {        
          return $this->registry->registry('current_product');
      }
  

 
}