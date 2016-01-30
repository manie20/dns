<?php

namespace Netcode\Dns\Tests\Modal;

use \Netcode\Dns\Modal\Zone;
use \Netcode\Dns\Modal\ZoneInterface;

/**
 * Unit Test for DNS Zone.
 */
class ZoneTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test Basic ZONE creation.
     */
    public function testZoneCreation()
    {
        $zone = new Zone();
        $this->assertTrue(
            $zone instanceof ZoneInterface
        );

        $this->assertEquals(
            (string) $zone,
            $zone::SOA_REQUIRED
        );
    }
}
