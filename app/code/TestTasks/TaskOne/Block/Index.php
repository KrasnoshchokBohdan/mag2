<?php

namespace TestTasks\TaskOne\Block;

class Index extends \Magento\Framework\View\Element\Template
{
    protected $_registry;
    protected $helperData;
    protected $httpContext;

    public function __construct(
        \TestTasks\TaskOne\Helper\Data          $helperData,
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry             $registry,
        \Magento\Framework\App\Http\Context     $httpContext,
        array                                   $data = []
    )
    {
        $this->helperData = $helperData;
        $this->_registry = $registry;
        $this->httpContext = $httpContext;
        parent::__construct($context, $data);
    }

    /**
     *
     * @return Magento\Catalog\Model\Product\Interceptor _eventObject: "product"
     */
    public function getCurrentProduct()
    {
        if ($this->helperData->getGeneralConfig('enable')) {
            $currentProduct = $this->_registry->registry('current_product');
            return $currentProduct;
        }
    }

    /**
     *
     * @return array
     */
    public function getCurrentCategoryIds()
    {
        if ($this->helperData->getGeneralConfig('enable')) {
            $categories = $this->getCurrentProduct()->getCategoryIds();
            return $categories;
        }
    }

    /**
     *
     * @return string
     */
    public function getMultiSelectField()
    {
        if ($this->helperData->getGeneralConfig('enable')) {
            $selectValue = $this->helperData->getGeneralConfig('multi_select');
            return $selectValue;
        }
    }

    /**
     *
     * @return string
     */
    public function getCategoryCompareRes()
    {
        $main = false;
        if ($this->helperData->getGeneralConfig('enable')) {
            $fields = $this->getMultiSelectField();
            $fieldsArr = explode(",", $fields);
            foreach ($fieldsArr as $field) {
                $result = in_array($field, $this->getCurrentCategoryIds());
                if ($result === true) {
                    $main = true;
                    $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
                    $category = $objectManager->create('Magento\Catalog\Model\Category')->load($field);
                    return $category->getName();
                }
            }
            return $main;
        }
    }

    /**
     * line for task number 1
     * @return string
     */
    public function getTaskStr()
    {
        if ($this->helperData->getGeneralConfig('enable')) {
            if (!$this->getCategoryCompareRes() === false) {
                return $this->getCategoryCompareRes() . '_' . $this->getCurrentProduct()->getData('entity_id') .
                    '_' . $this->getCurrentProduct()->getData('sku') . '_' . $this->getCurrentProduct()->getData('type_id');
            } else {
                null;
            }
        }
    }

    /**
     *
     * @return string date
     */
    public function getSalesEndDate()
    {
        if ($this->helperData->getGeneralConfig('enable')) {
            $selectDate = $this->helperData->getGeneralConfig('end_date');
            return $selectDate;
        }
    }

    /**
     *
     * @return string
     */
    public function getNDays()
    {
        if ($this->helperData->getGeneralConfig('enable')) {
            $selectN = $this->helperData->getGeneralConfig('n_day') + 1;
            return $selectN;
        }
    }

    /**
     * line for task number 1 additional task 1
     * @return string
     */
    public function getSalesEndDateStr()
    {
        if ($this->helperData->getGeneralConfig('enable')) {
            if (!$this->getCategoryCompareRes() === false) {
                $selectDate = strtotime($this->getSalesEndDate());
                $dateN = strtotime("-" . $this->getNDays() . " day", $selectDate);
                $currentDate = strtotime(date("Y-m-d"));
                if ($currentDate > $dateN && $selectDate > $currentDate) {
                    return 'The sale of this product ends at: ' . $this->getSalesEndDate();
                } else {
                    null;
                }
            }
        }
    }

    /**
     *
     * @return string
     */
    public function getCronPercentDiscount()
    {
        if ($this->helperData->getGeneralConfig('enable')) {
            if ($this->helperData->getGeneralConfig('cron_enable')) {
                $percentDiscount = $this->helperData->getGeneralConfig('cron_discount');
                return $percentDiscount;
            }
        }
    }

    /**
     *
     * @return bool
     */
    public function getCronMessageEnable()
    {
        if ($this->helperData->getGeneralConfig('enable')) {
            if ($this->helperData->getGeneralConfig('cron_enable')) {
                if ($this->helperData->getGeneralConfig('cron_message_enable')) {
                    return true;
                }
            }
        }
    }

    /**
     * line for task number 1 additional task 2
     * @return string
     */
    public function getCronDiscountStr()
    {
        if ($this->helperData->getGeneralConfig('enable')) {
            if (!$this->getCategoryCompareRes() === false) {
                if ($this->getCurrentCustomerGroupId() == 5) {
                    if ($this->getCronPercentDiscount()) {
                        if ($this->getCronMessageEnable() === true) {
                            $discountPrice = $this->getCurrentProduct()->getPrice() - ($this->getCurrentProduct()->getPrice() / 100) * $this->getCronPercentDiscount();
                            return 'From 8 to 10 discount for seniors: ' . $this->getCronPercentDiscount() . '%' . '<br />Discount price: $' . $discountPrice;
                        } else {
                            null;
                        }
                    }
                }
            }
        }
    }

    /**
     * line for task number 1 additional task 3
     * @return int
     */
    public function getCurrentCustomerGroupId()
    {
        if ($this->helperData->getGeneralConfig('enable')) {
            $id = $this->httpContext->getValue(\Magento\Customer\Model\Context::CONTEXT_GROUP);
            return $id;
        }
    }
}
