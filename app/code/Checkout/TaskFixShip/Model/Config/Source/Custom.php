<?php

namespace Checkout\TaskFixShip\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class Custom implements ArrayInterface
{

    /**
     * Retrieve Custom Option array
     * @return array
     */
    public function toOptionArray(): array
    {
        return [
            ['value' => 'London', 'label' => __('London')],
            ['value' => 'Oslo', 'label' => __('Oslo')],
            ['value' => 'Paris', 'label' => __('Paris')],
            ['value' => 'Rome', 'label' => __('Rome')],
            ['value' => 'Kiev', 'label' => __('Kiev')],
            ['value' => 'Berlin', 'label' => __('Berlin')],
            ['value' => 'Lisbon', 'label' => __('Lisbon')],
            ['value' => 'Amsterdam', 'label' => __('Amsterdam')]
        ];
    }
}
