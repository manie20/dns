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
                str_pad($record->getName(), 25, " "),
                str_pad($record->getTTL(), 10, " ", STR_PAD_LEFT),
                str_pad($record->getClass(), 8, " ", STR_PAD_LEFT),
                str_pad($record->getType(), 10, " ", STR_PAD_LEFT),
                str_pad($record->getContent(), 25, " ", STR_PAD_LEFT)
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
            '%s%s%s%s%s%s' . "\n",
            str_pad($mxRecord->getName(), 25, " "),
            str_pad($mxRecord->getTTL(), 10, " ", STR_PAD_LEFT),
            str_pad($mxRecord->getClass(), 8, " ", STR_PAD_LEFT),
            str_pad($mxRecord->getType(), 10, " ", STR_PAD_LEFT),
            str_pad($mxRecord->getPriority(), 8, " ", STR_PAD_LEFT),
            str_pad($mxRecord->getContent(), 25, " ", STR_PAD_LEFT)
        );
    }
}
