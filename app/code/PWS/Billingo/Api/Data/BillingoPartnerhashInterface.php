<?php

namespace PWS\Billingo\Api\Data;

interface BillingoPartnerhashInterface
{
    const ID = 'id';
    const PARTNER_ID = 'partner_id';
    const HASH = 'hash';

    /**
     * Get id
     * @return string|null
     */
    public function getId();

    /**
     * Set id
     * @param string $id
     * @return \PWS\Billingo\Api\Data\BillingoPartnerhashInterface
     */
    public function setId($id);

    /**
     * Get partner_id
     * @return string|null
     */
    public function getPartnerId();

    /**
     * Set partner_id
     * @param string $partner_id
     * @return \PWS\Billingo\Api\Data\BillingoPartnerhashInterface
     */
    public function setPartnerId($partner_id);

    /**
     * Get hash
     * @return string|null
     */
    public function getHash();

    /**
     * Set hash
     * @param string $hash
     * @return \PWS\Billingo\Api\Data\BillingoPartnerhashInterface
     */
    public function setHash($hash);
}
