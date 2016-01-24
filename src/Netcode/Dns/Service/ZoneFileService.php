<?php

namespace Netcode\DnsBundle\Service;

use Netcode\DnsBundle\Exception\SoaRequiredException;
use Netcode\DnsBundle\Modal\Records\SoaInterface;
use Netcode\DnsBundle\Modal\ZoneInterface;

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
    }
}
