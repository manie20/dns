DNS Library
==============
This package contains modals and services used for mapping DNS Zone's and DNS records.
It is used as a basic for the "manie20/rtr-dns-bundle" which offers the ability to manage Realtime Register DNS zones.

How to use?
--------------

```php
$soaRecord = new \Netcode\Dns\Modal\Records\SOA();
$soaRecord
    ->setName(new Domain('netcode.nl'))
    ->setEmailAddress('a.krijgsman@netcode.nl')
    ->setNameServer('ns')
    ->setSerialNumber(
        $soaRecord->getNewSerial()
    );

$zone = new Zone();
$zone->setSoaRecord($soaRecord);

$ARecord = new \Netcode\Dns\Modal\Records\A();
$ARecord
    ->setName('www')
    ->setContent('149.210.201.192')
    ->setTtl(3600);

$zone->addRecord($ARecord);
```