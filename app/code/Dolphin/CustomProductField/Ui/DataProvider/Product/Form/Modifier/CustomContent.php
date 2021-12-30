<?php

namespace Dolphin\CustomProductField\Ui\DataProvider\Product\Form\Modifier;

use Magento\Catalog\Model\Locator\LocatorInterface;
use Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\AbstractModifier;
use Magento\Ui\Component\Form\Element\DataType\Text;
use Magento\Ui\Component\Form\Element\Input;
use Magento\Ui\Component\Form\Element\MultiSelect;
use Magento\Ui\Component\Form\Element\Select;
use Magento\Ui\Component\Form\Field;
use Magento\Ui\Component\Form\Fieldset;

class CustomContent extends AbstractModifier
{
    private $locator;
    private $modeList;
    private $pageList;
    private $cacheManager;

    public function __construct(
        \Dolphin\CustomProductField\Model\Config\Source\CustomModeList $modeList,
        \Dolphin\CustomProductField\Model\Config\Source\CMSPageList $pageList,
        LocatorInterface $locator
    ) {
        $this->modeList = $modeList;
        $this->pageList = $pageList;
        $this->locator = $locator;
    }

    public function modifyMeta(array $meta)
    {
        $meta = array_replace_recursive(
            $meta,
            [
                'custom_content' => [
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'label' => __('Custom Content'),
                                'componentType' => Fieldset::NAME,
                                'dataScope' => 'data.product',
                                'collapsible' => true,
                                'sortOrder' => 5,
                            ],
                        ],
                    ],
                    'children' => [
                        'custom_title' => $this->getCustomTitle(),
                        'custom_mode' => $this->getCustomMode(),
                        'custom_cms_pages' => $this->getCustomCmsPages(),
                    ],
                ],
            ]
        );
        /* Hide Custom Content Attributes */
        if (isset($meta['custom-content-hide'])) {
            unset($meta['custom-content-hide']);
        }
        return $meta;
    }

    public function getCustomTitle()
    {
        return [
            'arguments' => [
                'data' => [
                    'config' => [
                        'label' => __('Custom Title'),
                        'componentType' => Field::NAME,
                        'formElement' => Input::NAME,
                        'dataScope' => 'custom_title',
                        'dataType' => Text::NAME,
                        'sortOrder' => 10,
                    ],
                ],
            ],
        ];
    }

    public function getCustomMode()
    {
        return [
            'arguments' => [
                'data' => [
                    'config' => [
                        'label' => __('Custom Mode Options'),
                        'component' => 'Dolphin_CustomProductField/js/form/element/custom-mode-list',
                        'componentType' => Field::NAME,
                        'formElement' => Select::NAME,
                        'dataScope' => 'custom_mode',
                        'dataType' => Text::NAME,
                        'sortOrder' => 20,
                        'options' => $this->getCustomModeOptions(),
                    ],
                ],
            ],
        ];
    }

    public function getCustomCmsPages()
    {
        return [
            'arguments' => [
                'data' => [
                    'config' => [
                        'label' => __('Custom CMS Pages'),
                        'componentType' => Field::NAME,
                        'component' => 'Magento_Catalog/js/components/new-category',
                        'elementTmpl' => 'ui/grid/filters/elements/ui-select',
                        'levelsVisibility' => 1,
                        'disableLabel' => true,
                        'formElement' => MultiSelect::NAME,
                        'dataScope' => 'custom_cms_pages',
                        'chipsEnabled' => true,
                        'dataType' => Text::NAME,
                        'sortOrder' => 30,
                        'required' => 1,
                        'options' => $this->getCustomCmsOptions(),
                        'validation' => ['required-entry' => 1],
                    ],
                ],
            ],
        ];
    }

    public function getCustomModeOptions()
    {
        return $this->modeList->toOptionArray();
    }

    public function getCustomCmsOptions()
    {
        return $this->pageList->toOptionArray();
    }

    public function modifyData(array $data)
    {
        $product = $this->locator->getProduct();
        $productId = (int) $product->getId();
        $cmsPages = [];
        $cmsCategoryIds = '';
        if ($product->getCustomCmsPages()) {
            $cmsPages = array_map('intval', explode(',', $product->getCustomCmsPages()));
        }
        if ($product->getCmsCategoryIds()) {
            $cmsCategoryIds = $product->getCmsCategoryIds();
        }

        $data = array_replace_recursive(
            $data, [
            $productId => [
                'product' => [
                    'custom_title' => $product->getCustomTitle(),
                    'custom_mode' => $product->getCustomMode(),
                    'custom_cms_pages' => $cmsPages,
                ],
            ],
        ]);
        return $data;
    }
}
