<?php

namespace Netcode\Dns\Modal;

use Netcode\Dns\Exception\InvalidDomainException;

/**
 * A fully qualified domain name (FQDN) is a domain name that specifies its exact location in the tree hierarchy of the
 * Domain Name System (DNS). A fully qualified domain name is distinguished by its lack of ambiguity: it can be
 * interpreted only in one way.
 */
class Domain
{
    /** @var string */
    protected $domainName;

    /**
     * What to return when a DomainObject is printed.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getDomainName();
    }

    /**
     * Initate Domain object.
     *
     * @param $fqdn
     */
    public function __construct($fqdn)
    {
        $this->setDomainName($fqdn);
    }

    /**
     * Set domain name.
     *
     * @param string $fqdn
     *
     * @return $this
     */
    public function setDomainName($fqdn)
    {
        if (false === $this->validateDomainName($fqdn) && $fqdn !== 'ns') {
            throw new InvalidDomainException(
                'The domain: ' . $fqdn . ' is not a valid FQDN. Please set a valid DomainName on the Domain class.'
            );
        }

        $this->domainName = $fqdn;

        return $this;
    }

    /**
     * Get domain name.
     *
     * @return string
     */
    public function getDomainName()
    {
        return $this->domainName;
    }

    /**
     * Validate the given domainname.
     *
     * @param string $fqdn
     *
     * @return bool
     */
    public function validateDomainName($fqdn)
    {
        if (preg_match("/^(?!\-)(?:[a-zA-Z\d\-]{0,62}[a-zA-Z\d]\.){1,126}(?!\d+)[a-zA-Z\d]{1,63}$/i", $fqdn)) {
            return true;
        }

        return false;
    }

    /**
     * Get the DNS Zone notation for a FQDN.
     *
     * @return string
     */
    public function getZonefileNotation()
    {
        return $this->getDomainName() . '.';
    }
}
