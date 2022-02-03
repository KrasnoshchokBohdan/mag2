<?php

namespace LiqpayMagento\LiqPay\Model\ResourceModel\Order\Grid;

use Magento\Sales\Model\ResourceModel\Order\Grid\Collection as OriginalCollection;

/**
 * Order grid extended collection
 */
class Collection extends OriginalCollection
{
    public const INVOICE_MESSAGE = '%LiqPay%';

    protected function _renderFiltersBefore()
    {
        $phrase = __(self::INVOICE_MESSAGE);
        $condition = sprintf('main_table.entity_id = sales_order_status_history.parent_id
        AND sales_order_status_history.comment LIKE "%s"', $phrase);
        $this->getSelect()->joinLeft('sales_order_status_history', $condition, ['comment']);
        $this->getSelect()->group('main_table.entity_id');

        parent::_renderFiltersBefore();
    }

    // Below function fixes error and endless loading when filters lead to empty page
    protected function _initSelect()
    {
        $this->addFilterToMap('created_at', 'main_table.created_at');

        parent::_initSelect();
    }
}
