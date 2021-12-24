<?php
namespace DCKAP\MySales\Model\ResourceModel\Data;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
	protected $_idFieldName = 'id';
	protected $_eventPrefix = 'my_sales_data_collection';
	protected $_eventObject = 'data_collection';

	/**
	 * Define resource model
	 *
	 * @return void
	 */
	protected function _construct()
	{
		$this->_init('DCKAP\MySales\Model\Data', 'DCKAP\MySales\Model\ResourceModel\Data');
	}

}