DNS Library
==============
This package contains modals and services used for mapping DNS Zone's and DNS records.
It is used as a basic for the "manie20/rtr-dns-bundle" which offers the ability to manage Realtime Register DNS zones.

How to use?
--------------
Let's create a DNS zone by coding objects and output a string which can be used in a DNS zonefile.

```php
use Netcode\Dns\Modal\Zone;
use Netcode\Dns\Modal\Domain;
use Netcode\Dns\Modal\Email;
use Netcode\Dns\Modal\Records\SOA;
use Netcode\Dns\Modal\Records\A;
use Netcode\Dns\Modal\Records\CNAME;
use Netcode\Dns\Service\ZoneFileService;
```

To start, let's create a new empty zone.
```php
$zone = new Zone();
```

The SOA record is mandatory for a DNS zone and has all the zone file information.
- Name contains the top-level domain for this zone.
- Email address is converted to the zone administrative contact.
- Nameserver is the server address the zone resided in. use 'ns' for the local nameserver.
- SerialNumber is an incremental identifier for when the zone file has changes.
```php
$soaRecord = new SOA();
$soaRecord
    ->setName(
        new Domain('netcode.nl')
    )
    ->setEmailAddress(
        new Email('a.krijgsman@netcode.nl')
    )
    ->setNameServer(
        new Domain('ns')
    )
    ->setSerialNumber(
        $soaRecord->getNewSerial()
    );

// Add the SOA Record to the newly created Zone.
$zone->setSoaRecord($soaRecord);
```

Now let's add some DNS records to the zone:
```php
$aRecord = new A();
$aRecord->setContent('127.0.0.1');
$zone->addRecord($aRecord);

$aRecord = new A();
$aRecord
   ->setName('www')
   ->setContent('127.0.0.1')
   ->setTTL(300);
$zone->addRecord($aRecord);


$cnameRecord = new CNAME();
$cnameRecord
    ->setName('mail')
    ->setContent('www')
    ->setTTL(7200);
$zone->addRecord($cnameRecord);

// And add the MX record:
$mxRecord = new MX();
$mxRecord
    ->setContent('mail')
    ->setPriority('10')
    ->setTTL(7200);
$zone->addRecord($mxRecord);
```

To test your fully populated zone, you can use the ZoneFileService to output the zone definition.
If you feel this needs changes please contact me; I do not actually use it on a running nameserver.
```php
$zoneFileService = new ZoneFileService();
$zoneFileService->getZoneText($zone)
```

Resulting in this output:
> netcode.nl. IN SOA ns a.krijgsman.netcode.nl. ( 2016013101 86000 7200 1209600 600 )
>                                          IN         A                127.0.0.1
> www                             300      IN         A                127.0.0.1
> mail                           7200      IN     CNAME                      www
>                                7200      IN        MX      10                     mail

