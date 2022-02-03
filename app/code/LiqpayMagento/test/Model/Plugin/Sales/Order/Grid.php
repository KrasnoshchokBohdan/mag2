<?php


namespace LiqpayMagento\LiqPay\Model\Plugin\Sales\Order;

class Grid
{
    public const INVOICE_MESSAGE = '%LiqPay%';

    public function afterSearch($intercepter, $collection)
    {
        $phrase = __(self::INVOICE_MESSAGE);
        $condition = sprintf('main_table.entity_id = sales_order_status_history.parent_id
        AND sales_order_status_history.comment LIKE "%s"', $phrase);
        $collection->getSelect()->joinLeft('sales_order_status_history', $condition, ['comment']);
        $collection->getSelect()->group('main_table.entity_id');
        return $collection;
    }
}
