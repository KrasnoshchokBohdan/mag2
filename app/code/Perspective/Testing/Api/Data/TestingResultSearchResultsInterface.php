<?php
declare(strict_types=1);

namespace Perspective\Testing\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface TestingResultSearchResultsInterface extends SearchResultsInterface
{

    /**
     * Get testing_result list.
     * @return \Perspective\Testing\Api\Data\TestingResultInterface[]
     */
    public function getItems(): array;

    /**
     * Set test_id list.
     * @param \Perspective\Testing\Api\Data\TestingResultInterface[] $items
     * @return $this
     */
    public function setItems(array $items): static;
}

