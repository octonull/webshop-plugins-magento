<?php


namespace PWS\Billingo\Model;

use PWS\Billingo\Api\BillingoRepositoryInterface;
use PWS\Billingo\Model\ResourceModel\Billingo as ResourceBillingo;
use PWS\Billingo\Api\Data\BillingoInterfaceFactory;
use PWS\Billingo\Api\Data\BillingoInterface;

use PWS\Billingo\Model\ResourceModel\Billingo\CollectionFactory as BillingoCollectionFactory;
use PWS\Billingo\Api\Data\BillingoSearchResultsInterfaceFactory;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\StoreManagerInterface;

use Magento\Framework\Api\SearchCriteriaInterface;

class BillingoRepository implements billingoRepositoryInterface
{

    protected $billingoCollectionFactory;

    protected $resource;

    protected $dataBillingoFactory;

    protected $searchResultsFactory;

    private $storeManager;

    protected $dataObjectHelper;

    protected $dataObjectProcessor;

    protected $billingoFactory;


    /**
     * @param ResourceBillingo $resource
     * @param BillingoFactory $billingoFactory
     * @param BillingoInterfaceFactory $dataBillingoFactory
     * @param BillingoCollectionFactory $billingoCollectionFactory
     * @param BillingoSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        ResourceBillingo $resource,
        BillingoFactory $billingoFactory,
        BillingoInterfaceFactory $dataBillingoFactory,
        BillingoCollectionFactory $billingoCollectionFactory,
        BillingoSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager
    )
    {
        $this->resource = $resource;
        $this->billingoFactory = $billingoFactory;
        $this->billingoCollectionFactory = $billingoCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataBillingoFactory = $dataBillingoFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
    }

    /**
     * {@inheritdoc}
     */
    public function save(BillingoInterface $billingo) {
        /* if (empty($billingo->getStoreId())) {
            $storeId = $this->storeManager->getStore()->getId();
            $billingo->setStoreId($storeId);
        } */
        try {
            $billingo->getResource()->save($billingo);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__('Could not save the billingo: %1', $exception->getMessage()));
        }
        return $billingo;
    }

    /**
     * {@inheritdoc}
     */
    public function getById($billingoId)
    {
        $billingo = $this->billingoFactory->create();
        $billingo->getResource()->load($billingo, $billingoId);
        if (!$billingo->getId()) {
            throw new NoSuchEntityException(__('Billingo with id "%1" does not exist.', $billingoId));
        }
        return $billingo;
    }

    /**
     * {@inheritdoc}
     */
    public function getList(SearchCriteriaInterface $criteria) {
        $collection = $this->billingoCollectionFactory->create();
        foreach ($criteria->getFilterGroups() as $filterGroup) {
            foreach ($filterGroup->getFilters() as $filter) {
                if ($filter->getField() === 'store_id') {
                    $collection->addStoreFilter($filter->getValue(), false);
                    continue;
                }
                $condition = $filter->getConditionType() ?: 'eq';
                $collection->addFieldToFilter($filter->getField(), [$condition => $filter->getValue()]);
            }
        }
        
        $sortOrders = $criteria->getSortOrders();
        if ($sortOrders) {
            /** @var SortOrder $sortOrder */
            foreach ($sortOrders as $sortOrder) {
                $collection->addOrder($sortOrder->getField(), ($sortOrder->getDirection() == SortOrder::SORT_ASC) ? 'ASC' : 'DESC');
            }
        }
        $collection->setCurPage($criteria->getCurrentPage());
        $collection->setPageSize($criteria->getPageSize());
        
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $searchResults->setTotalCount($collection->getSize());
        $searchResults->setItems($collection->getItems());
        return $searchResults;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(BillingoInterface $billingo) {
        try {
            $billingo->getResource()->delete($billingo);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__('Could not delete the Billingo: %1', $exception->getMessage()));
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($billingoId) // not used
    {
        return $this->delete($this->getById($billingoId));
    }
}
