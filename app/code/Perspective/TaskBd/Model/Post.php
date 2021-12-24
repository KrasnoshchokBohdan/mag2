<?php
namespace Perspective\TaskBd\Model;
class Post extends \Magento\Framework\Model\AbstractModel 
{
	protected function _construct()
		{
			$this->_init('Perspective\TaskBd\Model\ResourceModel\Post');
		}
}