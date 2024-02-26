<?php

namespace PWS\Billingo\Model\ResourceModel;

class BillingoPartnerhash extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    /**
     * Define resource model
     */
    protected function _construct()
    {
        $this->_init('pws_billingo_partnerhash', 'id');
    }
}
