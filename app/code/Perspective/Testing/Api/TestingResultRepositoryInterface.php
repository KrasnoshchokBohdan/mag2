<?php
declare(strict_types=1);

namespace Perspective\Testing\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Perspective\Testing\Api\Data\TestingResultInterface;
use Perspective\Testing\Api\Data\TestingResultSearchResultsInterface;

interface TestingResultRepositoryInterface
{

    /**
     * Save testing_result
     * @param TestingResultInterface $testingResult
     * @return TestingResultInterface
     * @throws LocalizedException
     */
    public function save(
        TestingResultInterface $testingResult
    ): TestingResultInterface;

    /**
     * Retrieve testing_result
     * @param int $testingResultId
     * @return TestingResultInterface
     * @throws LocalizedException
     */
    public function get(int $testingResultId): TestingResultInterface;

    /**
     * Retrieve testing_result matching the specified criteria.
     * @param SearchCriteriaInterface $searchCriteria
     * @return TestingResultSearchResultsInterface
     * @throws LocalizedException
     */
    public function getList(
        SearchCriteriaInterface $searchCriteria
    ): TestingResultSearchResultsInterface;

    /**
     * Delete testing_result
     * @param TestingResultInterface $testingResult
     * @return bool true on success
     * @throws LocalizedException
     */
    public function delete(
        TestingResultInterface $testingResult
    ): bool;

    /**
     * Delete testing_result by ID
     * @param int $testingResultId
     * @return bool true on success
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function deleteById(int $testingResultId): bool;
}

