<?php

namespace Netcode\Dns\Modal;

use Netcode\Dns\Modal\Records\RecordInterface;
use Netcode\Dns\Modal\Records\SoaInterface;

/**
 * Defining required methods for a Zone Object.
 */
interface ZoneInterface
{
    /**
     * Add Record to zone.
     *
     * @param RecordInterface $record
     *
     * @return ZoneInterface
     */
    public function addRecord(RecordInterface $record);

    /**
     * Delete a record.
     *
     * @param RecordInterface $record
     *
     * @return boolean
     */
    public function deleteRecord(RecordInterface $record);

    /**
     * Get records.
     *
     * @return array
     */
    public function getRecords();

    /**
     * Set Zone SOA record.
     *
     * @param SoaInterface $soa
     *
     * @return ZoneInterface
     */
    public function setSoaRecord(SoaInterface $soa);

    /**
     * Get Zone SOA record.
     *
     * @return SoaInterface
     */
    public function getSoaRecord();
}
