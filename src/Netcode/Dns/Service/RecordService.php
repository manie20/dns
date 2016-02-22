<?php

namespace Netcode\Dns\Service;

use Netcode\Dns\Exception\InvalidRecordTypeException;
use Netcode\Dns\Modal\Records\A;
use Netcode\Dns\Modal\Records\AAAA;
use Netcode\Dns\Modal\Records\CNAME;
use Netcode\Dns\Modal\Records\MX;
use Netcode\Dns\Modal\Records\NAPTR;
use Netcode\Dns\Modal\Records\NS;
use Netcode\Dns\Modal\Records\PTR;
use Netcode\Dns\Modal\Records\SRV;
use Netcode\Dns\Modal\Records\TXT;

/**
 * Service to retrieve record types.
 */
class RecordService
{
    /**
     * Get Record By Type.
     *
     * @param string $recordType
     *
     * @return mixed
     *
     * @throws InvalidRecordTypeException
     */
    public function getRecordByType($recordType)
    {
        switch (strtoupper($recordType)) {
            case "A":
                return new A();
                break;

            case "AAAA":
                return new AAAA();
                break;

            case "CNAME":
                return new CNAME();
                break;

            case "MX":
                return new MX();
                break;

            case "NAPTR":
                return new NAPTR();
                break;

            case "NS":
                return new NS();
                break;

            case "PTR":
                return new PTR();
                break;

            case "SRV":
                return new SRV();
                break;

            case "TXT":
                return new SRV();
                break;

            default:
                throw new InvalidRecordTypeException();
        }
    }
}
