<?php
declare(strict_types=1);

namespace Perspective\Testing\Model;

use Magento\Framework\Model\AbstractModel;
use Perspective\Testing\Api\Data\TestingResultInterface;

class TestingResult extends AbstractModel implements TestingResultInterface
{

    /**
     * @return void
     */
    public function _construct(): void
    {
        $this->_init(ResourceModel\TestingResult::class);
    }

    /**
     * @inheritDoc
     */
    public function getTestingResultId(): ?int
    {
        return $this->getData(self::TESTING_RESULT_ID);
    }

    /**
     * @inheritDoc
     */
    public function setTestingResultId(int $testingResultId): static
    {
        return $this->setData(self::TESTING_RESULT_ID, $testingResultId);
    }

    /**
     * @inheritDoc
     */
    public function getTestId(): ?int
    {
        return $this->getData(self::TEST_ID);
    }

    /**
     * @inheritDoc
     */
    public function setTestId(int $testId): static
    {
        return $this->setData(self::TEST_ID, $testId);
    }

    /**
     * @inheritDoc
     */
    public function getCustomerId(): ?int
    {
        return $this->getData(self::CUSTOMER_ID);
    }

    /**
     * @inheritDoc
     */
    public function setCustomerId($customerId): static
    {
        return $this->setData(self::CUSTOMER_ID, $customerId);
    }

    /**
     * @inheritDoc
     */
    public function getStatus(): ?int
    {
        return $this->getData(self::STATUS);
    }

    /**
     * @inheritDoc
     */
    public function setStatus($status): static
    {
        return $this->setData(self::STATUS, $status);
    }

    /**
     * @inheritDoc
     */
    public function getResult(): ?string
    {
        return $this->getData(self::RESULT);
    }

    /**
     * @inheritDoc
     */
    public function setResult($result): static
    {
        return $this->setData(self::RESULT, $result);
    }

    /**
     * @inheritDoc
     */
    public function getGrade(): ?int
    {
        return $this->getData(self::GRADE);
    }

    /**
     * @inheritDoc
     */
    public function setGrade($grade): static
    {
        return $this->setData(self::GRADE, $grade);
    }

    /**
     * @inheritDoc
     */
    public function getQuestionsResult(): ?string
    {
        return $this->getData(self::QUESTIONS_RESULT);
    }

    /**
     * @inheritDoc
     */
    public function setQuestionsResult($questionsResult): static
    {
        return $this->setData(self::QUESTIONS_RESULT, $questionsResult);
    }
}
