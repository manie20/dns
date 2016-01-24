<?php

namespace Netcode\DnsBundle\Tests;

use Netcode\DnsBundle\Modal\Zone;
use Netcode\DnsBundle\Modal\Records\Soa;

class ZoneTest extends PHPUnit_Framework_TestCase
{
    public function testSOARecord()
    {
        $zone = new Zone();
        $soa = new Soa();

        $zone->setSoaRecord($soa);



        $this->assertFalse(
            $bytes[1] === $bytes[2]
        );


        $this->assertTrue(function_exists('random_bytes'));
    }
}
