<?php

namespace DCKAP\MySales\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Data extends AbstractDb
{
	public function _construct()
	{
		$this->_init("my_sales", 'id');  //6. Создать модель по таблице Продажи
	}
}
