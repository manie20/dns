<?php

namespace Netcode\Dns\Modal;

use Netcode\Dns\Exception\SoaRequiredException;
use Netcode\Dns\Modal\Records\RecordInterface;
use Netcode\Dns\Modal\Records\SoaInterface;
use Netcode\Dns\Service\ZoneFileService;
use Netcode\Dns\Exception\SoaMandatoryFieldsException;

/**
 * Zone is any distinct, contiguous portion of the domain name space in the Domain Name System (DNS) for which
 * administrative responsibility has been delegated to a single manager.
 */
class Zone implements ZoneInterface
{
    /** string */
    const SOA_REQUIRED = 'A SOA Record is mandatory for a DNS Zone.';

    /** @var array */
    protected $records = array();

    /** @var SoaInterface */
    protected $soa;

    /**
     * Print the serialized representation of a zone file.
     *
     * @return string
     */
    public function __toString()
    {
        try {
            $zoneFileService = new ZoneFileService();

            return $zoneFileService->getZoneText($this);
        } catch(SoaRequiredException $e) {

            return self::SOA_REQUIRED;
        }
    }

    /**
     * Add Record to zone.
     *
     * @param RecordInterface $record
     *
     * @return ZoneInterface
     */
    public function addRecord(RecordInterface $record)
    {
        $this->records[$record->getKey()] = $record;

        return $this;
    }

    /**
     * Delete a record.
     *
     * @param RecordInterface $record
     *
     * @return boolean
     */
    public function deleteRecord(RecordInterface $record)
    {
        if (true === isset($this->records[$record->getKey()])) {
            unset($this->records[$record->getKey()]);
            return true;
        }

        return false;
    }

    /**
     * Get records.
     *
     * @return array
     */
    public function getRecords()
    {
        return $this->records;
    }

    /**
     * Set Zone SOA record.
     *
     * @param SoaInterface $soa
     *
     * @return ZoneInterface
     *
     * @throws SoaMandatoryFieldsException
     */
    public function setSoaRecord(SoaInterface $soa)
    {
        if (true === $soa->hasNullFields()) {
            throw new SoaMandatoryFieldsException('The fields in the SOA Object are all mandatory.');
        }

        $this->soa = $soa;

        return $this;
    }

    /**
     * Get Zone SOA record.
     *
     * @return SoaInterface
     */
    public function getSoaRecord()
    {
        return $this->soa;
    }
}
