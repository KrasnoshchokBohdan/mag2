<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 *
 * Created By : Rohan Hapani
 */
namespace Order\Cancel\Model;

use Magento\Framework\Model\AbstractModel;
use Order\Cancel\Model\ResourceModel\Blog as BlogResourceModel;

class Blog extends \Magento\Framework\Model\AbstractModel
{
    protected function _construct()
    {
        $this->_init(BlogResourceModel::class);
    }
}
