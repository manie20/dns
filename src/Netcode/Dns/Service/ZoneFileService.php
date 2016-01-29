<?php

namespace Netcode\Dns\Service;

use Netcode\Dns\Exception\SoaRequiredException;
use Netcode\Dns\Modal\Records\SoaInterface;
use Netcode\Dns\Modal\ZoneInterface;

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

        return $this->getSoaMarkup($zone->getSoaRecord());
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
            '$TTL    %s' . "\n" .
            '$ORIGIN %s' . "\n",
            $soaRecord->getTtl(),
            $soaRecord->getName()->getZonefileNotation()
        );
    }
}
