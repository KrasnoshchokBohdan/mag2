<?php
namespace DCKAP\MySales\Setup\Patch\Data;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use DCKAP\MySales\Model\DataFactory;
use DCKAP\MySales\Model\ResourceModel\Data;
class AddData implements DataPatchInterface
{
private $DataFactory;
private $DataResource;
private $moduleDataSetup;
public function __construct(
DataFactory $DataFactory,
Data $DataResource,
ModuleDataSetupInterface $moduleDataSetup
)
{
$this->DataFactory = $DataFactory;
$this->DataResource = $DataResource;
$this->moduleDataSetup=$moduleDataSetup;
}
public function apply()
{
    //2. Заполнить таблицу пятью записями о продажах. Предусмотреть, чтобы две продажи имели одинаковое название товара.(Data Patch)
////$this->moduleDataSetup->startSetup();
//$NewDataDTO=$this->DataFactory->create();    	   
//$NewDataDTO->setProductName("Product1")->setQuantity('10')->setDate('2021-10-01')->setDiscount('0.05');
//$this->DataResource->save($NewDataDTO);
//$NewDataDTO=$this->DataFactory->create();  
//$NewDataDTO->setProductName("Product2")->setQuantity('20')->setDate('2021-10-02')->setDiscount('0.1');
//$this->DataResource->save($NewDataDTO);
//$NewDataDTO=$this->DataFactory->create();    	   
//$NewDataDTO->setProductName("Product3")->setQuantity('30')->setDate('2021-10-03')->setDiscount('0.15');
//$this->DataResource->save($NewDataDTO);
//$NewDataDTO=$this->DataFactory->create();    	   
//$NewDataDTO->setProductName("Product4")->setQuantity('40')->setDate('2021-10-04')->setDiscount('0.1');
//$this->DataResource->save($NewDataDTO);
//$NewDataDTO=$this->DataFactory->create();    	   
//$NewDataDTO->setProductName("Product2")->setQuantity('30')->setDate('2021-10-05')->setDiscount('0.1');
//$this->DataResource->save($NewDataDTO);
////$this->moduleDataSetup->endSetup();

    //4. Заполнить этот столбик данными для пяти записей
//$NewDataDTO=$this->DataFactory->create();    	   
//$NewDataDTO->setProductName("Product1")->setQuantity('10')->setDate('2021-10-01')->setPrice('10')->setBonus('0.05');
//$this->DataResource->save($NewDataDTO);
//$NewDataDTO=$this->DataFactory->create(); 
//$NewDataDTO->setProductName("Product2")->setQuantity('20')->setDate('2021-10-02')->setPrice('20')->setBonus('0.1');
//$this->DataResource->save($NewDataDTO);
//$NewDataDTO=$this->DataFactory->create();    	   
//$NewDataDTO->setProductName("Product3")->setQuantity('30')->setDate('2021-10-03')->setPrice('30')->setBonus('0.15');
//$this->DataResource->save($NewDataDTO);
//$NewDataDTO=$this->DataFactory->create();    	   
//$NewDataDTO->setProductName("Product4")->setQuantity('40')->setDate('2021-10-04')->setPrice('40')->setBonus('0.1');
//$this->DataResource->save($NewDataDTO);
//$NewDataDTO=$this->DataFactory->create();    	   
//$NewDataDTO->setProductName("Product2")->setQuantity('30')->setDate('2021-10-05')->setPrice('20')->setBonus('0.1');
//$this->DataResource->save($NewDataDTO);

    //7. Добавить еще две записи в таблицу с помощью модели
$NewDataDTO=$this->DataFactory->create();    	   
$NewDataDTO->setProductName("Product5")->setQuantity('50')->setDate('2021-10-06')->setPrice('50')->setBonus('0.05');
$this->DataResource->save($NewDataDTO);
$NewDataDTO=$this->DataFactory->create();    	   
$NewDataDTO->setProductName("Product6")->setQuantity('60')->setDate('2021-10-07')->setPrice('60')->setBonus('0.05');
$this->DataResource->save($NewDataDTO);
}
public static function getDependencies()
{
return [];
}
public function getAliases()
{
return [];
}
}