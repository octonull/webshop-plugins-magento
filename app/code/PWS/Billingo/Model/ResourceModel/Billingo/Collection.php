<?php

namespace PWS\Billingo\Model\ResourceModel\Billingo;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * Define resource model
     */
    protected function _construct()
    {
        $this->_init('PWS\Billingo\Model\Billingo', 'PWS\Billingo\Model\ResourceModel\Billingo');
    }
}
