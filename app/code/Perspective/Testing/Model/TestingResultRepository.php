<?php
declare(strict_types=1);

namespace Perspective\Testing\Model;

use Exception;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Perspective\Testing\Api\Data\TestingResultInterface;
use Perspective\Testing\Api\Data\TestingResultInterfaceFactory;
use Perspective\Testing\Api\Data\TestingResultSearchResultsInterface;
use Perspective\Testing\Api\Data\TestingResultSearchResultsInterfaceFactory;
use Perspective\Testing\Api\TestingResultRepositoryInterface;
use Perspective\Testing\Model\ResourceModel\TestingResult as ResourceTestingResult;
use Perspective\Testing\Model\ResourceModel\TestingResult\CollectionFactory as TestingResultCollectionFactory;

class TestingResultRepository implements TestingResultRepositoryInterface
{

    /**
     * @var ResourceTestingResult
     */
    protected ResourceTestingResult $resource;

    /**
     * @var TestingResult
     */
    protected TestingResult $searchResultsFactory;

    /**
     * @var CollectionProcessorInterface
     */
    protected CollectionProcessorInterface $collectionProcessor;

    /**
     * @var TestingResultCollectionFactory
     */
    protected TestingResultCollectionFactory $testingResultCollectionFactory;

    /**
     * @var TestingResultInterfaceFactory
     */
    protected TestingResultInterfaceFactory $testingResultFactory;

    /**
     * @param ResourceTestingResult $resource
     * @param TestingResultInterfaceFactory $testingResultFactory
     * @param TestingResultCollectionFactory $testingResultCollectionFactory
     * @param TestingResultSearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        ResourceTestingResult $resource,
        TestingResultInterfaceFactory $testingResultFactory,
        TestingResultCollectionFactory $testingResultCollectionFactory,
        TestingResultSearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->resource = $resource;
        $this->testingResultFactory = $testingResultFactory;
        $this->testingResultCollectionFactory = $testingResultCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @inheritDoc
     */
    public function save(TestingResultInterface $testingResult): TestingResultInterface
    {
        try {
            $this->resource->save($testingResult);
        } catch (Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the testingResult: %1',
                $exception->getMessage()
            ));
        }
        return $testingResult;
    }

    /**
     * @inheritDoc
     */
    public function get($testingResultId): TestingResultInterface
    {
        $testingResult = $this->testingResultFactory->create();
        $this->resource->load($testingResult, $testingResultId);
        if (!$testingResult->getId()) {
            throw new NoSuchEntityException(__('testing_result with id "%1" does not exist.', $testingResultId));
        }
        return $testingResult;
    }

    /**
     * @inheritDoc
     */
    public function getList(
        SearchCriteriaInterface $criteria
    ): TestingResultSearchResultsInterface {
        $collection = $this->testingResultCollectionFactory->create();

        $this->collectionProcessor->process($criteria, $collection);

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);

        $items = [];
        foreach ($collection as $model) {
            $items[] = $model;
        }

        $searchResults->setItems($items);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * @inheritDoc
     */
    public function delete(TestingResultInterface $testingResult): bool
    {
        try {
            $testingResultModel = $this->testingResultFactory->create();
            $this->resource->load($testingResultModel, $testingResult->getTestingResultId());
            $this->resource->delete($testingResultModel);
        } catch (Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the testing_result: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * @inheritDoc
     */
    public function deleteById($testingResultId): bool
    {
        return $this->delete($this->get($testingResultId));
    }
}
