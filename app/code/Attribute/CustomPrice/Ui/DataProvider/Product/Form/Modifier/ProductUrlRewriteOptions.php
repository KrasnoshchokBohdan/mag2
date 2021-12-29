<?php

namespace Attribute\CustomPrice\Ui\DataProvider\Product\Form\Modifier;






use Magento\Catalog\Api\Data\ProductAttributeInterface;
use Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\AbstractModifier;
use Magento\Catalog\Model\Locator\LocatorInterface;
use Magento\Ui\Component\Form\Element\Checkbox;
use Magento\Ui\Component\Form\Element\DataType\Text;
use Magento\Ui\Component\Form\Field;
use Magento\Framework\Stdlib\ArrayManager;

/**
 * Class adds a checkbox "url_key_generate_rewrites_for_options" after input "url_key" for product form
 */
class ProductUrlRewriteOptions extends AbstractModifier
{
    public const URL_KEY_GENERATE_REWRITES_FOR_OPTIONS_NAME = 'url_key_generate_rewrites_for_options';
    /**
     * @var LocatorInterface
     */
    private $locator;
    /**
     * @var ArrayManager
     */
    private $arrayManager;

    /**
     * @param LocatorInterface $locator
     * @param ArrayManager $arrayManager
     */
    public function __construct(
        LocatorInterface $locator,
        ArrayManager $arrayManager
    ) {
        $this->locator = $locator;
        $this->arrayManager = $arrayManager;
    }

    /**
     * @inheritdoc
     */
    public function modifyMeta(array $meta)
    {
        //To get the product
        $product = $this->locator->getProduct();

        return $this->addUrlRewriteWithOptionsCheckbox($meta);
    }

    /**
     * @inheritdoc
     */
    public function modifyData(array $data)
    {
        return $data;
    }

    /**
     * Adding URL rewrite checkbox to meta
     *
     * @param array $meta
     * @return array
     */
    protected function addUrlRewriteWithOptionsCheckbox(array $meta)
    {
        //I guess u should specify your attribute here - to add checkbox after
        //but I've not tested it.
        $urlPath = $this->arrayManager->findPath(
            ProductAttributeInterface::CODE_SEO_FIELD_URL_KEY,
            $meta,
            null,
            'children'
        );

        if ($urlPath) {
            $containerPath = $this->arrayManager->slicePath($urlPath, 0, -2);
            $urlKey = $this->locator->getProduct();
            $urlKey = $this->locator->getProduct()->getData('custom_price');
            $meta = $this->arrayManager->merge(
                $containerPath,
                $meta,
                [
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'component' => 'Magento_Ui/js/form/components/group',
                                'label' => false,
                                'required' => false,
                            ],
                        ],
                    ],
                ]
            );

            $checkbox['arguments']['data']['config'] = [
                'componentType' => Field::NAME,
                'formElement' => Checkbox::NAME,
                'dataType' => Text::NAME,
                'description' => __('Generate URLs with options'),
                'dataScope' => self::URL_KEY_GENERATE_REWRITES_FOR_OPTIONS_NAME,
                'value' => $urlKey,
            ];

            $meta = $this->arrayManager->merge(
                $urlPath . '/arguments/data/config',
                $meta,
                ['valueUpdate' => 'keyup']
            );
            $meta = $this->arrayManager->merge(
                $containerPath . '/children',
                $meta,
                [self::URL_KEY_GENERATE_REWRITES_FOR_OPTIONS_NAME => $checkbox]
            );
            $meta = $this->arrayManager->merge(
                $containerPath . '/arguments/data/config',
                $meta,
                ['breakLine' => true]
            );
        }

        return $meta;
    }
}
