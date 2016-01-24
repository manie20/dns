<?php

namespace Netcode\Dns\Tests;

use Netcode\Dns\Modal\Zone;
use Netcode\Dns\Modal\Records\Soa;

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