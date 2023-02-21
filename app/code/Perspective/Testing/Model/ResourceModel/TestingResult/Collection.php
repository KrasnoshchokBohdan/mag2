<?php
declare(strict_types=1);

namespace Perspective\Testing\Model\ResourceModel\TestingResult;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Perspective\Testing\Api\Data\TestingResultInterface;

class Collection extends AbstractCollection
{

    /**
     * @var string
     */
    protected $_idFieldName = TestingResultInterface::TESTING_RESULT_ID;

    /**
     * @return void
     */
    protected function _construct(): void
    {
        $this->_init(
            \Perspective\Testing\Model\TestingResult::class,
            \Perspective\Testing\Model\ResourceModel\TestingResult::class
        );
    }
}
