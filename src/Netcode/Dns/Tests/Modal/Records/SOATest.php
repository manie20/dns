<?php

namespace Netcode\Dns\Tests\Modal\Records;

use \Netcode\Dns\Modal\Records\SoaInterface;
use \Netcode\Dns\Modal\Records\SOA;
use \Netcode\Dns\Modal\Domain;
use \Netcode\Dns\Modal\Zone;
use \Netcode\Dns\Modal\Email;

/**
 * Unit Test for DNS SOA Record.
 */
class SOATest extends \PHPUnit_Framework_TestCase
{
    /** @var \Netcode\Dns\Modal\Records\SOA */
    private $SOA;

    /** @var \Netcode\Dns\Modal\Zone */
    private $zone;

    /**
     * Populate Test instances.
     */
    public function setUp()
    {
        parent::setUp();
        $this->SOA = new SOA();
        $this->zone = new Zone();
    }

    /**
     * Cleanup Test instance.
     */
    public function tearDown()
    {
        $this->SOA = null;
        $this->zone = null;
        parent::tearDown();
    }

    /**
     * Test SOA Record creation and coupling it to the Zone Object.
     *
     * @param Domain $domain
     * @param Email  $email
     * @param Domain $nameServer
     *
     * @dataProvider providerTestSoaRecordCreation
     */
    public function testSoaRecordCreation(Domain $domain, Email $email, Domain $nameServer)
    {
        $this->assertTrue(
            $this->SOA->hasNullFields(),
            'A default instance of a SOA record should contain null fields.'
        );

        $this->SOA
            ->setName($domain)
            ->setEmailAddress($email)
            ->setNameServer($nameServer)
            ->setSerialNumber(
                $this->SOA->getNewSerial()
            );

        $this->assertFalse(
            $this->SOA->hasNullFields(),
            'The populated instance seems to have fields containing null values.'
        );

        $this
            ->zone
            ->setSoaRecord($this->SOA);

        $this->assertTrue(
            $this->zone->getSoaRecord() instanceof SoaInterface
        );
    }

    /**
     * Provider for data to Test SOA-Record creation.
     *
     * @return array
     */
    public function providerTestSoaRecordCreation()
    {
        $returnSet = array();
        $build = array(
            array(
                'domain'     => 'netcode.nl',
                'email'      => 'tech@netcode.nl',
                'nameServer' => 'ns'
            ),
            array(
                'domain'     => 'google.com',
                'email'      => 'support@google.com',
                'nameServer' => 'ns1.google.com'
            ),
            array(
                'domain'     => 'just-a-domain.com',
                'email'      => 'help@just-a-domain.com',
                'nameServer' => 'ns1.myregistrar.com'
            ),
        );

        foreach ($build as $record) {
            $domain = new Domain();
            $domain->setDomainName($record['domain']);

            $email = new Email();
            $email->setEmailAddress($record['email']);

            $nameServer = new Domain();
            $nameServer->setDomainName($record['nameServer']);

            $returnSet[] = array(
                $domain,
                $email,
                $nameServer
            );
        }

        return $returnSet;
    }

    /**
     * Test SerialNumber generation on existing serial.
     *
     * @param integer $serialNumber
     * @param integer $expectedNewSerial
     *
     * @dataProvider providerTestSoaSerialRevision
     */
    public function testSoaSerialRevision($serialNumber, $expectedNewSerial)
    {
        $this
            ->SOA
            ->setSerialNumber($serialNumber);

        $this->assertEquals(
            $expectedNewSerial,
            $this
                ->SOA
                ->getNewSerial()
        );
    }

    /**
     * Give data to test revision changes on SerialNumber.
     *
     * @return array
     */
    public function providerTestSoaSerialRevision()
    {
        $today = new \DateTime();
        $todayStamp = $today->format("Ymd");

        return array(
            array(
                '201401010002',
                $todayStamp . '01'
            ),
            array(
                '123456',
                $todayStamp . '01'
            ),
            array(
                $todayStamp . '1',
                $todayStamp . '02'
            ),
            array(
                $todayStamp . '01',
                $todayStamp . '02'
            ),
            array(
                $todayStamp . '09',
                $todayStamp . '10'
            ),
            array(
                $todayStamp . '99',
                $todayStamp . '100'
            ),
            array(
                '2015123002',
                $todayStamp . '01'
            ),
            array(
                'RandomTestString',
                $todayStamp . '01'
            ),
            array(
                null,
                $todayStamp . '01'
            )
        );
    }
}
