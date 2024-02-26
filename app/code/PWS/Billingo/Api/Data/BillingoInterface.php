<?php

namespace PWS\Billingo\Api\Data;

interface BillingoInterface
{
    const INVOICE_NR = 'invoice_nr';
    const DATE_ADD = 'date_add';
    const ID = 'id';
    const INVOICE_ID = 'invoice_id';
    const LINK = 'link';
    const ID_ORDER = 'id_order';
    const BILLINGO_ID = 'billingo_id'; // ez itt nem szerepel a db-ben

    /**
     * Get id
     * @return string|null
     */
    public function getId();

    /**
     * Set id
     * @param string $id
     * @return \PWS\Billingo\Api\Data\BillingoInterface
     */
    public function setId($id);

    /**
     * Get id_order
     * @return string|null
     */
    public function getIdOrder();

    /**
     * Set id_order
     * @param string $id_order
     * @return \PWS\Billingo\Api\Data\BillingoInterface
     */
    public function setIdOrder($id_order);

    /**
     * Get link
     * @return string|null
     */
    public function getLink();

    /**
     * Set link
     * @param string $link
     * @return \PWS\Billingo\Api\Data\BillingoInterface
     */
    public function setLink($link);

    /**
     * Get invoice_id
     * @return string|null
     */
    public function getInvoiceId();

    /**
     * Set invoice_id
     * @param string $invoice_id
     * @return \PWS\Billingo\Api\Data\BillingoInterface
     */
    public function setInvoiceId($invoice_id);

    /**
     * Get invoice_nr
     * @return string|null
     */
    public function getInvoiceNr();

    /**
     * Set invoice_nr
     * @param string $invoice_nr
     * @return \PWS\Billingo\Api\Data\BillingoInterface
     */
    public function setInvoiceNr($invoice_nr);

    /**
     * Get date_add
     * @return string|null
     */
    public function getDateAdd();

    /**
     * Set date_add
     * @param string $date_add
     * @return \PWS\Billingo\Api\Data\BillingoInterface
     */
    public function setDateAdd($date_add);
}
