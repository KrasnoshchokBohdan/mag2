<?php

namespace Attribute\CustomPrice\Ui\DataProvider\Product\Form\Modifier;

use Magento\Catalog\Model\Locator\LocatorInterface;
use Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\AbstractModifier;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Stdlib\ArrayManager;
use Magento\Ui\Component\Form\Element\Checkbox;
use Magento\Ui\Component\Form\Element\DataType\Number;
use Magento\Ui\Component\Form\Element\DataType\Price;
use Magento\Ui\Component\Form\Element\Input;
use Magento\Ui\Component\Form\Field;
use Magento\Ui\Component\Form\Fieldset;

//use Attribute\CustomPrice\Helper\Data;
use Attribute\CustomPrice\Service\Check;

/**
 * Class GiftMessageDataProvider
 */
class CustomPrice extends AbstractModifier
{
    const CUSTOM_PRICE_ATTRIBUTE = 'custom_price_attribute';
    const CUSTOM_DATA_SCOPE = 'data.product';

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var LocatorInterface
     */
    protected $locator;

    /**
     * @var ArrayManager
     */
    protected $arrayManager;
    /**
     * @var Check
     */
    private $data;

    /**
     * @param LocatorInterface $locator
     * @param ArrayManager $arrayManager
     * @param ScopeConfigInterface $scopeConfig
     * @param Check $data
     */
    public function __construct(
        LocatorInterface     $locator,
        ArrayManager         $arrayManager,
        ScopeConfigInterface $scopeConfig,
        Check                $data
    )
    {
        $this->locator = $locator;
        $this->arrayManager = $arrayManager;
        $this->scopeConfig = $scopeConfig;
        $this->data = $data;
    }

    public function modifyMeta(array $meta): array
    {

        $meta['custom_price_parent'] = [
            'arguments' => [
                'data' => [
                    'config' => [
                        'label' => __('Custom Price'),
                        'formElement' => 'container',
                        'dataScope' => static::CUSTOM_DATA_SCOPE,
                        'sortOrder' => 1,
                        'collapsible' => true,
                        'breakLine' => true,
                        'valueUpdate' => 'keyup',
                        'componentType' => Fieldset::NAME,
                    ]
                ]
            ],
            'children' => [
                'custom_price' => [
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'formElement' => Input::NAME,
                                'componentType' => Field::NAME,
                                'dataScope' => static::CUSTOM_PRICE_ATTRIBUTE,
                                'dataType' => Price::NAME,
                                'component' => 'Magento_Ui/js/form/element/single-checkbox-use-config',
                                'elementTmpl' => 'ui/form/element/input',
                                'addbefore' => '$',
//                                'value' => $getDiscount,
                                'additionalClasses' => 'admin__field admin__field-small',
                                'description' => __('Custom price'),
                                'label' => __('Custom price')
                            ]
                        ]
                    ]
                ],
                'custom_price_checkbox' => [
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'label' => __('Custom Price Checkbox'),
                                'dataType' => Number::NAME,
                                'formElement' => Checkbox::NAME,
                                'componentType' => Field::NAME,
                                'description' => __('Custom Price Checkbox'),
                                'component' => 'Magento_Ui/js/form/element/single-checkbox-use-config',
                                'additionalClasses' => 'admin__field admin__field-x-small',
                                'prefer' => 'toggle',
//                                'value' => $customPriceValue,
                                'dataScope' => 'use_config_' . static::CUSTOM_PRICE_ATTRIBUTE,
                                'valueMap' => [
                                    'false' => '0',
                                    'true' => '1',
                                ],
                                'exports' => [
                                    'checked' => '!${$.parentName}.' . 'custom_price'
                                        . ':isUseConfig',
                                ],
                                'imports' => [
                                    'disabled' => '${$.parentName}.' . 'custom_price'
                                        . ':isUseDefault',
                                ]
                            ]
                        ]
                    ]
                ]
            ],
        ];
        return $meta;
    }

    /**
     * {@inheritdoc}
     */
    public function modifyData(array $data)
    {
        $product = $this->locator->getProduct();
        $getCurrentCustomPrice = $product->getData('price');
        $getCustomPriceDiscount = $this->data->getDiscountCustomPrice();
        $customPriceValue = $product->getData('custom_price_attribute');

        if (!$this->data->getModuleEnabled()) {
            return;
        }
        if ($customPriceValue == 0 || empty($product->getId())) {
            $data[$product->getId()]['product']['custom_price_attribute'] = $getCurrentCustomPrice +
                ($getCurrentCustomPrice *
                    $getCustomPriceDiscount / 100);
        }
        return $data;
    }
}
