<?php
namespace DCKAP\Datapatch\Model;
use Magento\Framework\Model\AbstractModel;
class Contactdetails extends AbstractModel{
	protected function _construct()
	{
		$this->_init("DCKAP\Datapatch\Model\ResourceModel\Contactdetails");
	}
}
?>