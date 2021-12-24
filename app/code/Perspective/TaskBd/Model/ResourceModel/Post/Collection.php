<?php
namespace Perspective\TaskBd\Model\ResourceModel\Post;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
	protected $_idFieldName = 'ID';
	protected $_eventPrefix = 'perspective_taskbd_post_collection';
	protected $_eventObject = 'post_collection';

	/**
	 * Define resource model
	 *
	 * @return void
	 */
	protected function _construct()
	{
		$this->_init('Perspective\TaskBd\Model\Post', 'Perspective\TaskBd\Model\ResourceModel\Post');
	}

}