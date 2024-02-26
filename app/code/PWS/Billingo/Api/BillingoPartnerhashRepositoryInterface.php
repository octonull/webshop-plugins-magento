<?php

namespace PWS\Billingo\Api;

interface BillingoPartnerhashRepositoryInterface
{

    /**
     * Save Billingo
     * @param \PWS\Billingo\Api\Data\BillingoPartnerhashInterface $billingoPartnerhash
     * @return \PWS\Billingo\Api\Data\BillingoPartnerhashInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(\PWS\Billingo\Api\Data\BillingoPartnerhashInterface $billingoPartnerhash);

    /**
     * Retrieve Billingo Partner ID
     * @param string $partnerhash
     * @return $partnerId
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getByHash($partnerhash);
}
