<?php

namespace PWS\Billingo\Model;

use PWS\Billingo\Api\Data\BillingoInterface;

class Billingo extends \Magento\Framework\Model\AbstractModel implements BillingoInterface
{

    protected function _construct()
    {
        $this->_init('PWS\Billingo\Model\ResourceModel\Billingo');
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
     * @return \PWS\Billingo\Api\Data\BillingoInterface
     */
    public function setId($id)
    {
        return $this->setData(self::ID, $id);
    }

    /**
     * Get id_order
     * @return string
     */
    public function getIdOrder()
    {
        return $this->getData(self::ID_ORDER);
    }

    /**
     * Set id_order
     * @param string $id_order
     * @return \PWS\Billingo\Api\Data\BillingoInterface
     */
    public function setIdOrder($id_order)
    {
        return $this->setData(self::ID_ORDER, $id_order);
    }

    /**
     * Get link
     * @return string
     */
    public function getLink()
    {
        return $this->getData(self::LINK);
    }

    /**
     * Set link
     * @param string $link
     * @return \PWS\Billingo\Api\Data\BillingoInterface
     */
    public function setLink($link)
    {
        return $this->setData(self::LINK, $link);
    }

    /**
     * Get invoice_id
     * @return string
     */
    public function getInvoiceId()
    {
        return $this->getData(self::INVOICE_ID);
    }

    /**
     * Set invoice_id
     * @param string $invoice_id
     * @return \PWS\Billingo\Api\Data\BillingoInterface
     */
    public function setInvoiceId($invoice_id)
    {
        return $this->setData(self::INVOICE_ID, $invoice_id);
    }

    /**
     * Get invoice_nr
     * @return string
     */
    public function getInvoiceNr()
    {
        return $this->getData(self::INVOICE_NR);
    }

    /**
     * Set invoice_nr
     * @param string $invoice_nr
     * @return \PWS\Billingo\Api\Data\BillingoInterface
     */
    public function setInvoiceNr($invoice_nr)
    {
        return $this->setData(self::INVOICE_NR, $invoice_nr);
    }

    /**
     * Get date_add
     * @return string
     */
    public function getDateAdd()
    {
        return $this->getData(self::DATE_ADD);
    }

    /**
     * Set date_add
     * @param string $date_add
     * @return \PWS\Billingo\Api\Data\BillingoInterface
     */
    public function setDateAdd($date_add)
    {
        return $this->setData(self::DATE_ADD, $date_add);
    }
}
