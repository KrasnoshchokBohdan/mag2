<?php

namespace Perspective\TaskBd\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{
	protected $postFactory;

	public function __construct(\Perspective\TaskBd\Model\PostFactory $postFactory)
	{
		$this->postFactory = $postFactory;
	}

	public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
	{
		$data = [
		[
			'IDCat' => "4",
			'IDProd' => "12",
			'TextRev' => "Driven Backpack(4,12) review1",
			'Name' => "Ivan",
			'Email' => "Ivan@mail.com"
		],
		[
			'IDCat' => "4",
			'IDProd' => "12",
			'TextRev' => "Driven Backpack(4,12) review2",
			'Name' => "Sergey",
			'Email' => "Sergey@mail.com"
		],
		[
			'IDCat' => "14",
			'IDProd' => "436",
			'TextRev' => "Proteus Fitness Jackshirt(14,436) review",
			'Name' => "Petr",
			'Email' => "Petr@mail.com"
		],
		[
			'IDCat' => "14",
			'IDProd' => "420",
			'TextRev' => "Montana Wind Jacket(14,420) review",
			'Name' => "Igor",
			'Email' => "Igor@mail.com"
		],
		[
			'IDCat' => "23",
			'IDProd' => "1402",
			'TextRev' => "Olivia 1/4 Zip Light Jacket(23,1402) review",
			'Name' => "Marina",
			'Email' => "Marina@mail.com"
		],
		];

		foreach ($data as $elem)
		{
		$post = $this->postFactory->create();
		$post->addData($elem)->save();
		}
	}
}