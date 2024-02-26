<?php

namespace PWS\Billingo\Model;

use PWS\Billingo\Api\BillingoPartnerhashRepositoryInterface;
use PWS\Billingo\Model\ResourceModel\BillingoPartnerhash\Collection as BillingoPartnerhashCollection;
use PWS\Billingo\Api\Data\BillingoPartnerhashInterface;
use PWS\Billingo\Model\ResourceModel\BillingoPartnerhash as ResourceBillingoPartnerhash;
use PWS\Billingo\Model\ResourceModel\BillingoPartnerhash;

use Magento\Framework\Exception\CouldNotSaveException;

class BillingoPartnerhashRepository implements BillingoPartnerhashRepositoryInterface
{
    protected $billingoPartnerhashCollection;

    protected $resource;

    /**
     * @param BillingoPartnerhash $resource
     * @param BillingoPartnerhashCollection $billingoPartnerhashCollection
     */
    public function __construct(ResourceBillingoPartnerhash $resource, BillingoPartnerhashCollection $billingoPartnerhashCollection)
    {
        $this->resource = $resource;
        $this->billingoPartnerhashCollection = $billingoPartnerhashCollection;
    }

    /**
     * {@inheritdoc}
     */
    public function save(BillingoPartnerhashInterface $billingoPartnerhash) {
        try {
            $billingoPartnerhash->getResource()->save($billingoPartnerhash);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__('Could not save the partnerhash: %1', $exception->getMessage()));
        }
        return $billingoPartnerhash;
    }

    /**
     * {@inheritdoc}
     */
    public function getByHash($partnerhash) // not used :D
    {
        $this->billingoPartnerhashCollection->addFieldToFilter(BillingoPartnerhashInterface::HASH, ['eq' => $partnerhash]);
        $items = $this->billingoPartnerhashCollection->getItems();
        //var_dump($items);

        $partnerIdRow = $items->getFirstItem();
        $partnerIdData = $partnerIdRow->getData();

        //var_dump($partnerIdRow);
        //var_dump($partnerIdData);

        return $partnerIdData;
    }
}
