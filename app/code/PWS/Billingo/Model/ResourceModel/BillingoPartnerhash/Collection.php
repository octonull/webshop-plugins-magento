<?php

namespace PWS\Billingo\Model\ResourceModel\BillingoPartnerhash;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * Define resource model
     */
    protected function _construct()
    {
        $this->_init('PWS\Billingo\Model\BillingoPartnerhash', 'PWS\Billingo\Model\ResourceModel\BillingoPartnerhash');
    }
}
