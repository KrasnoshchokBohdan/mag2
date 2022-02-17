<?php

namespace Widget\Custom\Block\Widget;

use Magento\Backend\Block\Template\Context;
use Magento\Framework\Data\Form\Element\AbstractElement;

class Separator extends \Magento\Backend\Block\Template
{

    public function __construct(Context $context, array $data = [])
    {
        parent::__construct($context, $data);
    }

    public function prepareElementHtml(AbstractElement $element)
    {

        $element->setData('after_element_html', $this->_getAfterElementHtml());

        return $element;
    }

    /**
     * @return string
     */
    protected function _getAfterElementHtml()
    {
        $label = $this->getData('label')['tab'];

        return "<h3>" . $label . "</h3><hr>";
    }
}
