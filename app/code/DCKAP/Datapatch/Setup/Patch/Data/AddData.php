<?php
namespace DCKAP\Datapatch\Setup\Patch\Data;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchVersionInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use DCKAP\Datapatch\Model\ContactdetailsFactory;
Use DCKAP\Datapatch\Model\ResourceModel\Contactdetails;
class AddData implements DataPatchInterface, PatchVersionInterface
{
private $contactDetailsFactory;
private $contactDetailsResource;
private $moduleDataSetup;
public function __construct(
ContactdetailsFactory $contactDetailsFactory,
Contactdetails $contactDetailsResource,
ModuleDataSetupInterface $moduleDataSetup
)
{
$this->contactDetailsFactory = $contactDetailsFactory;
$this->contactDetailsResource = $contactDetailsResource;
$this->moduleDataSetup=$moduleDataSetup;
}
public function apply()
{
//Install data row into contact_details table
$this->moduleDataSetup->startSetup();
$contactDTO=$this->contactDetailsFactory->create();    	   
$contactDTO->setCustomerName('John')->setCustomerEmail('andrew@email.com')->setContactNo('9988884444');
$this->contactDetailsResource->save($contactDTO);
$this->moduleDataSetup->endSetup();
}
public static function getDependencies()
{
return [];
}
public static function getVersion()
{
return '1.0.1';
}
public function getAliases()
{
return [];
}
}