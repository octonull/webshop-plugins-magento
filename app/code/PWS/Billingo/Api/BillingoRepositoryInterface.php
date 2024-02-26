<?php

namespace PWS\Billingo\Api;

interface BillingoRepositoryInterface
{

    /**
     * Save Billingo
     * @param \PWS\Billingo\Api\Data\BillingoInterface $billingo
     * @return \PWS\Billingo\Api\Data\BillingoInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(\PWS\Billingo\Api\Data\BillingoInterface $billingo);

    /**
     * Retrieve Billingo
     * @param string $billingoId
     * @return \PWS\Billingo\Api\Data\BillingoInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($billingoId);

    /**
     * Retrieve Billingo matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \PWS\Billingo\Api\Data\BillingoSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     * Delete Billingo
     * @param \PWS\Billingo\Api\Data\BillingoInterface $billingo
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(\PWS\Billingo\Api\Data\BillingoInterface $billingo);

    /**
     * Delete Billingo by ID
     * @param string $billingoId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($billingoId);
}
