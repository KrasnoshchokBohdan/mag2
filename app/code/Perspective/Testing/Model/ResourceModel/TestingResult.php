<?php
declare(strict_types=1);

namespace Perspective\Testing\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Perspective\Testing\Api\Data\TestingResultInterface;

class TestingResult extends AbstractDb
{
    const TABLE_NAME = 'perspective_testing_testing_result';
    /**
     * @return void
     */
    protected function _construct(): void
    {
        $this->_init(self::TABLE_NAME, TestingResultInterface::TESTING_RESULT_ID);
    }
}
