<?php

namespace Netcode\Dns\Service;

use Netcode\Dns\Exception\SoaRequiredException;
use Netcode\Dns\Modal\Records\SoaInterface;
use Netcode\Dns\Modal\ZoneInterface;
use Netcode\Dns\Modal\Records\MX;

/**
 * Service used to generate a string used to write a DNS zone.
 */
class ZoneFileService
{
    /**
     * Get Zone file text as string.
     *
     * @param ZoneInterface $zone
     *
     * @return string
     *
     * @throws SoaRequiredException
     */
    public function getZoneText(ZoneInterface $zone)
    {
        if (false === ($zone->getSoaRecord() instanceof SoaInterface)) {
            throw new SoaRequiredException('The zone file supplied does nog seem to have a valid SOA record.');
        }

        return sprintf(
            '%s%s',
            $this
                ->getSoaMarkup(
                    $zone->getSoaRecord()
                ),
            $this
                ->getRecordMarkup(
                    $zone->getRecords()
                )
        );
    }

    /**
     * Get SOA record markup.
     *
     * @param SoaInterface $soaRecord
     *
     * @return string
     */
    private function getSoaMarkup(SoaInterface $soaRecord)
    {
        return sprintf(
            '%s %s %s %s %s ( %s %s %s %s %s )' . "\n",
            $soaRecord->getName()->getZonefileNotation(),
            $soaRecord->getClass(),
            $soaRecord,
            $soaRecord->getNameServer()->getZonefileNotation(),
            $soaRecord->getEmailAddress(),
            $soaRecord->getSerialNumber(),
            $soaRecord->getRefresh(),
            $soaRecord->getRetry(),
            $soaRecord->getExpiry(),
            $soaRecord->getMinimum()
        );
    }

    /**
     * Get Record markup.
     *
     * @param array $records
     *
     * @return string
     */
    private function getRecordMarkup($records)
    {
        $returnString = '';

        /** @var \Netcode\Dns\Modal\Records\RecordInterface $record */
        foreach ($records as $record)
        {
            if ($record instanceof MX) {
                $returnString .= $this->getMxMarkup($record);
                continue;
            }

            $returnString .= sprintf(
                '%s%s%s%s%s' . "\n",
                $record->getName(),
                $record->getTTL(),
                $record->getClass(),
                $record->getType(),
                $record->getContent()
            );
        }

        return $returnString;
    }

    /**
     * Get the markup for an MX Record within a Zone.
     *
     * @param MX $mxRecord
     *
     * @return string
     */
    private function getMxMarkup(MX $mxRecord)
    {
        return sprintf(
            '%s    %s    %s   %s    %s    %s' . "\n",
            $mxRecord->getName(),
            $mxRecord->getTTL(),
            $mxRecord->getClass(),
            $mxRecord->getType(),
            $mxRecord->getPriority(),
            $mxRecord->getContent()
        );
    }
}
