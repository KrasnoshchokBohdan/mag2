<?php
namespace DCKAP\MySales\Model;
use Magento\Framework\Model\AbstractModel;
class Data extends AbstractModel{
	protected function _construct()
	{
		$this->_init("DCKAP\MySales\Model\ResourceModel\Data");
	}
}
?>