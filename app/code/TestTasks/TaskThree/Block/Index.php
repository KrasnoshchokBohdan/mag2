<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 * Php version 7.4.
 * 
 * @category Some_Category
 * @package  Some_Package
 * @author   Display Name <someusername@example.com>
 * @license  some license
 * @link     ???
 */

namespace TestTasks\TaskThree\Block;

/**
 *  Short description
 *
 * @category   Some_Category
 * @package    Some_Package
 * @author     Display Name <someusername@example.com>
 * @license    some license
 * @link       ???
 * @since      00.00.00
 * @deprecated Some_deprecated
 * @api
 */
class Index extends \Magento\Framework\View\Element\Template
{
    /**
     * Registry collection
     *
     * @var object
     */
    protected $registry;
    /**
     * Rule collection
     *
     * @var object
     */
    protected $rules;

    /**
     * Index constructor
     * 
     * @param \Magento\Backend\Block\Template\Context $context  context
     * @param \Magento\Framework\Registry             $registry registry
     * @param \Magento\CatalogRule\Model\Rule         $rules    rules
     * @param array<Type>                             $data     data
     * 
     * @????(???)
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\CatalogRule\Model\Rule $rules,
        array $data = []
    ) {
        $this->registry = $registry;
        $this->rules = $rules;
        parent::__construct($context, $data);
    }
    /** 
     * Get current product
     * 
     * @return Object
     */
    public function getCurrentProduct()
    {
        $currentProduct = $this->registry->registry('current_product');
        return $currentProduct;
    }

    /** 
     * Get current product simple
     * 
     * @return bool
     */
    public function isCurrentProductSimple()
    {
        if ($this->getCurrentProduct()->getTypeId() == 'simple') {
            return true;
        }
        return false;
    }


    /**
     * Get special price end date
     * 
     * @return mixed
     */
    public function getSpecialPriceEndDate()
    {
        if ($this->isCurrentProductSimple()) {
            $currentProduct = $this->getCurrentProduct();
            $specialPriceEndDate = $currentProduct->getSpecialToDate();
            if ($specialPriceEndDate !== false) {
                if ($specialPriceEndDate !== null) {
                    $date = date_create($specialPriceEndDate);
                    return $date->Format('Y-m-d');
                }
                return null;
            }
            return null;
        }
        return null;
    }

    /**
     * Get rule price end date 
     * 
     * @return mixed
     */
    public function getRulePriceEndDate()
    {
        if ($this->isCurrentProductSimple()) {
            $rulesResoutseCollection =  $this->rules->getResourceCollection();
            $rules = $rulesResoutseCollection->addFieldToFilter('is_active', 1);
            $productId = $this->getCurrentProduct()->getData('entity_id');
            $date = 9999999;
            if (isset($rules)) {
                foreach ($rules as $rule) {
                    if (isset($rule->getMatchingProductIds()[$productId][1])) {
                        $toDate = $rule->getToDate();
                        if ($date > $toDate) {
                            $date = $toDate;
                        }
                    }
                }
                if ($date) {
                    return date_create($date)->Format('Y-m-d');
                }
                return null;
            }
            return null;
        }
    }


    /**
     * Get rules names
     * 
     * @return mixed
     */
    public function getRulesNames()
    {
        if ($this->isCurrentProductSimple()) {
            $rulesResoutseCollection =  $this->rules->getResourceCollection();
            $rules = $rulesResoutseCollection->addFieldToFilter('is_active', 1);
            $productId = $this->getCurrentProduct()->getData('entity_id');
            $names = [];
            if (isset($rules)) {
                foreach ($rules as $rule) {
                    if (isset($rule->getMatchingProductIds()[$productId][1])) {
                        $ruleName = $rule->getName();
                        $ruleDate = $rule->getToDate();
                        $names[] = ['name' => $ruleName, 'date' => $ruleDate];
                    }
                }
                return $names;
            }
            return null;
        }
        return null;
    }


    /**
     * Get smallest date
     * 
     * @return mixed
     */
    public function getSmallestDate()
    {
        if ($this->isCurrentProductSimple()) {
            $specialPriceEndaDate = $this->getSpecialPriceEndDate();
            $rulePriceEndDate = $this->getRulePriceEndDate();
            if ($specialPriceEndaDate == null &&  $rulePriceEndDate !== null) {
                return  $rulePriceEndDate;
            }
            if ($specialPriceEndaDate !== null &&  $rulePriceEndDate == null) {
                return  $specialPriceEndaDate;
            }

            if ($specialPriceEndaDate >  $rulePriceEndDate) {
                return  $rulePriceEndDate;
            } elseif ($specialPriceEndaDate <  $rulePriceEndDate) {
                return  $specialPriceEndaDate;
            } elseif ($specialPriceEndaDate ==  $rulePriceEndDate) {
                return  $specialPriceEndaDate;
            }
        }
    }
}
