<?php

namespace Netcode\DnsBundle\Modal;

use Netcode\DnsBundle\Exception\InvalidEmailException;

/**
 * Email class used for within DNS.
 *
 * Email address in DNS ar uniquely formatted. Example: – root.ns.nameserver.com. –
 * This is the email of the domain name administrator. Now, this is
 * really confusing, because people expect an @ to be in an email address. However in this case, email is sent to
 * root@ns.nameserver.com, but written as root.ns.nameserver.com .
 * And yes, remember to put the dot behind the domain name.
 */
class Email
{
    /** @var string */
    protected $emailAddress;

    /**
     * What to return when a DomainObject is printed.
     *
     * @return string
     */
    public function __toString()
    {
        if (true === $this->isValidDnsEmail($this->emailAddress)) {
            return $this->emailAddress;
        }

        if (true === $this->isValidRegularEmail($this->emailAddress)) {
            return $this->getDnsEmailFromRegularEmail($this->emailAddress);
        }

        return 'Not a valid e-mail has been given to the Object.';
    }

    /**
     * Set the e-mail address.
     *
     * @param string $emailAddress
     *
     * @return $this
     */
    public function setEmailAddress($emailAddress)
    {
        $this->emailAddress = $emailAddress;

        return $this;
    }

    /**
     * Get the e-mail address.
     *
     * @return string
     */
    public function getEmailAddress()
    {
        return $this->emailAddress;
    }

    /**
     * Is the given parameter a valid regular e-mail address.
     *
     * @param string $emailAddress
     *
     * @return bool
     */
    public function isValidRegularEmail($emailAddress)
    {
        return filter_var($emailAddress, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * Is the given parameter a valid DNS formatted e-mail address.
     *
     * @param string $emailAddress
     *
     * @return bool
     */
    public function isValidDnsEmail($emailAddress)
    {
        if (preg_match("/^(?!\-)(?:[a-zA-Z\d\-]{0,62}[a-zA-Z\d]\.)+\.?$/", $emailAddress)) {
            return true;
        }

        return false;
    }

    /**
     * Get DNS E-mail format from regular e-mail address.
     *
     * @param string $emailAddress
     *
     * @return string
     *
     * @throws InvalidEmailException
     */
    public function getDnsEmailFromRegularEmail($emailAddress)
    {
        if (false === $this->isValidRegularEmail($emailAddress)) {
            throw new InvalidEmailException(
                sprintf(
                    'The e-mail address supplied (%s) is not a valid e-mail address. Did you mean the getRegularEmailFromDnsEmail method?',
                    $emailAddress
                )
            );
        }

        return str_replace('@', '.', $emailAddress) . '.';
    }

    /**
     * Get DNS E-mail format from regular e-mail address.
     *
     * @param string $emailAddress
     *
     * @return string
     *
     * @throws InvalidEmailException
     */
    public function getRegularEmailFromDnsEmail($emailAddress)
    {
        if (false === $this->isValidDnsEmail($emailAddress)) {
            throw new InvalidEmailException(
                sprintf(
                    'The e-mail address supplied (%s) is not a valid DNS format. Did you mean the getDnsEmailFromRegularEmail method?',
                    $emailAddress
                )
            );
        }

        return rtrim(
            preg_replace('/\./', '@', $emailAddress, 1),
            '.'
        );
    }
}
