<?php

/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Learning\Foo\Model\Attribute\Backend;

class Material extends
\Magento\Eav\Model\Entity\Attribute\Backend\AbstractBackend
{
    /**
     * Validate
     * @param \Magento\Catalog\Model\Product $object
     * @throws \Magento\Framework\Exception\LocalizedException
     * @return bool
     */
    public function validate($object)
    {
        $value = $object->getData($this->getAttribute()->getAttributeCode());
        if (($object->getAttributeSetId() == 10) && ($value == 'test3')) {
            throw new \Magento\Framework\Exception\LocalizedException(
                __('Bottom can not be test3.')
            );
        }
        return true;
    }
}
