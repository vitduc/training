<?php

namespace Cowell\BasicTraining\Api\Data;

interface StudentSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get Student list.
     * @return \Cowell\BasicTraining\Api\Data\StudentInterface[]
     */
    public function getItems();

    /**
     * Set students list.
     * @param \Cowell\BasicTraining\Api\Data\StudentInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
