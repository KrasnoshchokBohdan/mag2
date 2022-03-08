<?php

namespace Widget\Custom\Block\Widget;

use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Catalog\Block\Product\Context;
use Magento\Catalog\Model\Product\Visibility;
use Magento\Catalog\Model\ResourceModel\Product\Collection;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\CatalogWidget\Block\Product\ProductsList;
use Magento\CatalogWidget\Model\Rule;
use Magento\Framework\App\Http\Context as HttpContext;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\Framework\Url\EncoderInterface;
use Magento\Framework\View\LayoutFactory;
use Magento\Rule\Model\Condition\Sql\Builder as SqlBuilder;
use Magento\Widget\Helper\Conditions;

class ProductGrid extends ProductsList
{
    const DEFAULT_SORT_BY = 'id';
    const DEFAULT_SORT_ORDER = 'asc';
    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;

    public function __construct(
        SerializerInterface         $serializer,
        Context                     $context,
        CollectionFactory           $productCollectionFactory,
        Visibility                  $catalogProductVisibility,
        HttpContext                 $httpContext,
        SqlBuilder                  $sqlBuilder,
        Rule                        $rule,
        Conditions                  $conditionsHelper,
        array                       $data = [],
        Json                        $json = null,
        LayoutFactory               $layoutFactory = null,
        EncoderInterface            $urlEncoder = null,
        CategoryRepositoryInterface $categoryRepository = null
    ) {
        $this->serializer = $serializer;
        parent::__construct(
            $context,
            $productCollectionFactory,
            $catalogProductVisibility,
            $httpContext,
            $sqlBuilder,
            $rule,
            $conditionsHelper,
            $data,
            $json,
            $layoutFactory,
            $urlEncoder,
            $categoryRepository
        );
    }

    /**
     * @return Collection
     * @throws LocalizedException
     */
    public function createCollectionTab1(): Collection
    {
        $collection1 = $this->productCollectionFactory->create();
        $collection1->setVisibility($this->catalogProductVisibility->getVisibleInCatalogIds());

        $collection1 = $this->_addProductAttributesAndPrices($collection1)
            ->addStoreFilter()
            ->setPageSize($this->getPageSize())
            ->setCurPage($this->getRequest()->getParam($this->getData('page_var_name'), 1))
            ->setOrder($this->getSortBy('products_sort_by'), $this->getSortOrder('products_sort_order'));

        $conditions1 = $this->getConditions();
        // $conditions->collectValidateAttributes($collection);
        $this->sqlBuilder->attachConditionToCollection($collection1, $conditions1);

        return $collection1;
    }

    /**
     * @return Collection
     * @throws LocalizedException
     */
    public function createCollectionTab2(): Collection
    {
        $collection2 = $this->productCollectionFactory->create();
        $collection2->setVisibility($this->catalogProductVisibility->getVisibleInCatalogIds());

        $collection2 = $this->_addProductAttributesAndPrices($collection2)
            ->addStoreFilter()
            ->setPageSize($this->getPageSize())
            ->setCurPage($this->getRequest()->getParam($this->getData('page_var_name'), 1))
            ->setOrder($this->getSortBy('products_sort_by2'), $this->getSortOrder('products_sort_order2'));

        $conditions2 = $this->getConditions();
        $conditions33 = $this->serializer->unserialize($this->getData('condition2'));

        $conditions2->getData('conditions')[0]->setData($conditions33['conditions'][0]);
        $this->sqlBuilder->attachConditionToCollection($collection2, $conditions2);

        return $collection2;
    }

    /**
     * @return Collection
     * @throws LocalizedException
     */
    public function createCollectionTab3(): Collection
    {
        $collection3 = $this->productCollectionFactory->create();
        $collection3->setVisibility($this->catalogProductVisibility->getVisibleInCatalogIds());

        $collection3 = $this->_addProductAttributesAndPrices($collection3)
            ->addStoreFilter()
            ->setPageSize($this->getPageSize())
            ->setCurPage($this->getRequest()->getParam($this->getData('page_var_name'), 1))
            ->setOrder($this->getSortBy('products_sort_order3'), $this->getSortOrder('products_sort_order3'));

        $conditions3 = $this->getConditions();
        $conditions33 = $this->serializer->unserialize($this->getData('condition3'));

        $conditions3->getData('conditions')[0]->setData($conditions33['conditions'][0]);
        $this->sqlBuilder->attachConditionToCollection($collection3, $conditions3);

        return $collection3;
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function getSortBy(string $key)
    {
        if (!$this->hasData($key)) {
            $this->setData($key, self::DEFAULT_SORT_BY);
        }
        return $this->getData($key);
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function getSortOrder(string $key)
    {
        if (!$this->hasData($key)) {
            $this->setData($key, self::DEFAULT_SORT_ORDER);
        }
        return $this->getData($key);
    }
}



