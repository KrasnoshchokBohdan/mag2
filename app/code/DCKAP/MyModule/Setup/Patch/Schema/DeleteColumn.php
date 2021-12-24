<?php
/**
* Copyright © 2019 Magenest. All rights reserved.
* See COPYING.txt for license details.
*/
namespace DCKAP\MyModule\Setup\Patch\Schema;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\Patch\SchemaPatchInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
class DeleteColumn implements SchemaPatchInterface
{
private $moduleDataSetup;
public function __construct(
ModuleDataSetupInterface $moduleDataSetup
) {
$this->moduleDataSetup = $moduleDataSetup;
}  
public static function getDependencies()
{
return [];
}
public function getAliases()
{
return [];
}
public function apply()
{
$this->moduleDataSetup->startSetup();
$this->moduleDataSetup->getConnection()->dropColumn($this->moduleDataSetup->getTable('intray_table2'),
'name',
$schemaName = null
);
$this->moduleDataSetup->endSetup();
}
}