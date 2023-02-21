<?php
declare(strict_types=1);

namespace Perspective\Testing\Api\Data;

interface TestingResultInterface
{

    const CUSTOMER_ID = 'customer_id';
    const STATUS = 'status';
    const GRADE = 'grade';
    const QUESTIONS_RESULT = 'questions_result';
    const TEST_ID = 'test_id';
    const TESTING_RESULT_ID = 'testing_result_id';
    const RESULT = 'result';

    /**
     * Get testing_result_id
     * @return int|null
     */
    public function getTestingResultId(): ?int;

    /**
     * Set testing_result_id
     * @param int $testingResultId
     * @return $this
     */
    public function setTestingResultId(int $testingResultId): static;

    /**
     * Get test_id
     * @return int|null
     */
    public function getTestId(): ?int;

    /**
     * Set test_id
     * @param int $testId
     * @return $this
     */
    public function setTestId(int $testId): static;

    /**
     * Get customer_id
     * @return int|null
     */
    public function getCustomerId(): ?int;

    /**
     * Set customer_id
     * @param int $customerId
     * @return $this
     */
    public function setCustomerId(int $customerId): static;

    /**
     * Get status
     * @return int|null
     */
    public function getStatus(): ?int;

    /**
     * Set status
     * @param int $status
     * @return $this
     */
    public function setStatus(int $status): static;

    /**
     * Get result
     * @return string|null
     */
    public function getResult(): ?string;

    /**
     * Set result
     * @param string $result
     * @return $this
     */
    public function setResult(string $result): static;

    /**
     * Get grade
     * @return int|null
     */
    public function getGrade(): ?int;

    /**
     * Set grade
     * @param int $grade
     * @return $this
     */
    public function setGrade(int $grade) : static;

    /**
     * Get questions_result
     * @return string|null
     */
    public function getQuestionsResult(): ?string;

    /**
     * Set questions_result
     * @param string $questionsResult
     * @return $this
     */
    public function setQuestionsResult(string $questionsResult): static;
}
