<?php

namespace PWS\Billingo\Model;

use PWS\Billingo\Api\Data\BillingoPartnerhashInterface;

class BillingoPartnerhash extends \Magento\Framework\Model\AbstractModel implements BillingoPartnerhashInterface
{

    protected function _construct()
    {
        $this->_init('PWS\Billingo\Model\ResourceModel\BillingoPartnerhash');
    }

    /**
     * Get id
     * @return string
     */
    public function getId()
    {
        return $this->getData(self::ID);
    }

    /**
     * Set id
     * @param string $id
     * @return \PWS\Billingo\Api\Data\BillingoPartnerhashInterface
     */
    public function setId($id)
    {
        return $this->setData(self::ID, $id);
    }

    /**
     * Get partner_id
     * @return string
     */
    public function getPartnerId()
    {
        return $this->getData(self::PARTNER_ID);
    }

    /**
     * Set partner_id
     * @param string $partner_id
     * @return \PWS\Billingo\Api\Data\BillingoPartnerhashInterface
     */
    public function setPartnerId($partner_id)
    {
        return $this->setData(self::PARTNER_ID, $partner_id);
    }

    /**
     * Get hash
     * @return string
     */
    public function getHash()
    {
        return $this->getData(self::HASH);
    }

    /**
     * Set hash
     * @param string $hash
     * @return \PWS\Billingo\Api\Data\BillingoPartnerhashInterface
     */
    public function setHash($hash)
    {
        return $this->setData(self::HASH, $hash);
    }
}
