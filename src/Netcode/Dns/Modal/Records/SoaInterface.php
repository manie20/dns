<?php

namespace Netcode\Dns\Modal\Records;

use \Netcode\Dns\Modal\Domain;
use Netcode\Dns\Modal\Email;

/**
 * Define the functionality for the SOA (Start of Authority) record class for use in a zone.
 *
 * Credits about the doc blocks should go to Sangeetha Naik, since I used her post on bobcares.com:
 * e.g. https://bobcares.com/blog/understanding-soa-records/
 */
interface SoaInterface
{
    /**
     * Checks if the object has no null attributes.
     *
     * @return boolean
     */
    public function hasNullFields();

    /**
     * Get a newly generated serial based on existing SOA record.
     *
     * @return int
     */
    public function getNewSerial();

    /**
     * Set the toplevel domain for this zone. (example.com)
     *
     * @param \Netcode\Dns\Modal\Domain $domain
     *
     * @return SoaInterface $this
     */
    public function setName(Domain $domain);

    /**
     * Get the zone name.
     *
     * @return \Netcode\Dns\Modal\Domain
     */
    public function getName();

    /**
     * Set TTL in seconds.
     *
     * TTL – 14400 – TTL defines the duration in seconds that the record may be cached by client side programs.
     * If it is set as 0, it indicates that the record should not be cached.
     * The range is defined to be between 0 to 2147483647 (close to 68 years !)
     *
     * @param int $seconds
     *
     * @return SoaInterface $this
     */
    public function setTtl($seconds);

    /**
     * Get TTL in seconds.
     *
     * @return int
     */
    public function getTtl();

    /**
     * Set CLASS.
     *
     * Class – IN – The class shows the type of record. IN equates to Internet. Other options are all historic.
     * So as long as your DNS is on the Internet or Intranet, you must use IN.
     *
     * @param string $class
     *
     * @return SoaInterface $this
     */
    public function setClass($class = 'IN');

    /**
     * Get CLASS.
     *
     * @return string
     */
    public function getClass();

    /**
     * Set Nameserver
     *
     * Nameserver – ns.nameserver.com. – The nameserver is the server which holds the zone files.
     * It can be either an external server in which case, the entire domain name must be specified followed by a dot.
     * In case it is defined in this zone file, then it can be written as “ns” .
     *
     * @param \Netcode\Dns\Modal\Domain $nameserver
     *
     * @return SoaInterface $this
     */
    public function setNameServer(Domain $nameserver);

    /**
     * Get Nameserver.
     *
     * @return \Netcode\Dns\Modal\Domain
     */
    public function getNameServer();

    /**
     * Set E-mail address.
     *
     * Email address – root.ns.nameserver.com. – This is the email of the domain name administrator. Now, this is
     * really confusing, because people expect an @ to be in an email address. However in this case, email is sent to
     * root@ns.nameserver.com, but written as root.ns.nameserver.com .
     * And yes, remember to put the dot behind the domain name.
     *
     * @param Email $emailAddress
     *
     * @return SoaInterface $this
     */
    public function setEmailAddress(Email $emailAddress);

    /**
     * Get E-mail address.
     *
     * @return \Netcode\Dns\Modal\Domain
     */
    public function getEmailAddress();

    /**
     * Set Serial number.
     *
     * This is a sort of a revision numbering system to show the changes made to the DNS Zone.
     * This number has to increment , whenever any change is made to the Zone file.
     * The standard convention is to use the date of update YYYYMMDDnn, where nn is a revision number in case more
     * than one updates are done in a day. So if the first update done today would be 2005301200 and second update
     * would be 2005301201.
     *
     * @param int $serial
     *
     * @return SoaInterface $this
     */
    public function setSerialNumber($serial);

    /**
     * Get Serial number.
     *
     * @return int
     */
    public function getSerialNumber();

    /**
     * Set Refresh.
     *
     * Refresh – 86000 – This is time(in seconds) when the slave DNS server will refresh from the master.
     * This value represents how often a secondary will poll the primary server to see if the serial number for the
     * zone has increased (so it knows to request a new copy of the data for the zone).
     * It can be written as “23h88M” indicating 23 hours and 88 minutes. If you have a regular Internet server,
     * you can keep it between 6 to 24 hours.
     *
     * @param int $seconds
     *
     * @return SoaInterface $this
     */
    public function setRefresh($seconds);

    /**
     * Get Refresh
     *
     * @return int
     */
    public function getRefresh();

    /**
     * Set Retry.
     *
     * Retry – 7200 – Now assume that a slave tried to contact the master server and failed to contact it because it
     * was down. The Retry value (time in seconds) will tell it when to get back. This value is not very important
     * and can be a fraction of the refresh value.
     *
     * @param int $seconds
     *
     * @return SoaInterface $this
     */
    public function setRetry($seconds);

    /**
     * Get Retry
     *
     * @return int
     */
    public function getRetry();

    /**
     * Set Expiry.
     *
     * Expiry – 1209600 – This is the time (in seconds) that a slave server will keep a cached zone file as valid,
     * if it can’t contact the primary server. If this value were set to say 2 weeks ( in seconds),
     * what it means is that a slave would still be able to give out domain information from its cached zone file
     * for 2 weeks, without anyone knowing the difference. The recommended value is between 2 to 4 weeks.
     *
     * @param int $seconds
     *
     * @return SoaInterface $this
     */
    public function setExpiry($seconds);

    /**
     * Get Expiry
     *
     * @return int
     */
    public function getExpiry();

    /**
     * Set Minimum.
     *
     * Minimum – 600 – This is the default time(in seconds) that the slave servers should cache the Zone file.
     * This is the most important time field in the SOA Record. If your DNS information keeps changing, keep it down to
     * a day or less. Otherwise if your DNS record doesn’t change regularly, step it up between 1 to 5 days.
     * The benefit of keeping this value high, is that your website speeds increase drastically as a result of
     * reduced lookups. Caching servers around the globe would cache your records and this improves site performance.
     *
     * @param int $seconds
     *
     * @return SoaInterface $this
     */
    public function setMinimum($seconds);

    /**
     * Get Minimum
     *
     * @return int
     */
    public function getMinimum();
}
