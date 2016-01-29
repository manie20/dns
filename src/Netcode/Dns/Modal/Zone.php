<?php

namespace Netcode\Dns\Modal;

use Netcode\Dns\Modal\Records\RecordInterface;
use Netcode\Dns\Modal\Records\SoaInterface;
use Netcode\Dns\Service\ZoneFileService;

/**
 * Zone is any distinct, contiguous portion of the domain name space in the Domain Name System (DNS) for which
 * administrative responsibility has been delegated to a single manager.
 */
class Zone implements ZoneInterface
{
    /** @var array */
    protected $records = array();

    /** @var SoaInterface */
    protected $soa;

    /**
     * Print the serialized representation of a zone file.
     *
     * @return string
     *
     * @throws \Netcode\Dns\Exception\SoaRequiredException
     */
    public function __toString()
    {
        $zoneFileService = new ZoneFileService();
        return $zoneFileService->getZoneText($this);
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
     */
    public function setSoaRecord(SoaInterface $soa)
    {
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
