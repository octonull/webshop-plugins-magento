<?php

namespace PWS\Billingo\Api\Data;

interface BillingoSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get Billingo list.
     * @return \PWS\Billingo\Api\Data\BillingoInterface[]
     */
    public function getItems();

    /**
     * Set id list.
     * @param \PWS\Billingo\Api\Data\BillingoInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
