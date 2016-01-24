<?php

namespace Netcode\DnsBundle\Modal\Records;

class BaseRecord implements RecordInterface
{
    protected $name;

    protected $type;

    protected $content;

    protected $ttl;

    protected $priority;

    /**
     * @inheritdoc
     */
    public function __toString()
    {
        $reflect = new \ReflectionClass($this);

        return $reflect->getShortName() ;
    }

    /**
     * @inheritdoc
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @inheritdoc
     */
    public function setType(RecordInterface $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @inheritdoc
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getContent()
    {
        $this->content;
    }

    /**
     * @inheritdoc
     */
    public function setTTL($seconds)
    {
        $this->ttl = $seconds;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getTTL()
    {
        return $this->ttl;
    }

    /**
     * @inheritdoc
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * @inheritdoc
     */
    public function getKey()
    {
        return md5($this->getName() . $this . $this->getPriority());
    }
}
