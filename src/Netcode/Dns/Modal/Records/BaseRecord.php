<?php

namespace Netcode\Dns\Modal\Records;

/**
 * BaseRecord handles the common functionality which is used for all different types of records.
 */
class BaseRecord implements RecordInterface
{
    /** @var string */
    protected $name;

    /** @var RecordInterface */
    protected $type;

    /** @var string */
    protected $content;

    /** @var int */
    protected $ttl;

    /** @var int */
    protected $priority;

    /**
     * Get class name for usage as type of record.
     *
     * @return string
     */
    public function __toString()
    {
        $reflect = new \ReflectionClass($this);

        return $reflect->getShortName();
    }

    /**
     * Set record name.
     *
     * @param $name
     *
     * @return RecordInterface $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get record name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set type of Zone record.
     *
     * @param RecordInterface $type
     *
     * @return RecordInterface $this
     */
    public function setType(RecordInterface $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type of record.
     *
     * @return RecordInterface
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set record content.
     *
     * @param string $content
     *
     * @return RecordInterface $this
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content for the record.
     *
     * @return string
     */
    public function getContent()
    {
        $this->content;
    }

    /**
     * Set Time-To-Live in seconds.
     *
     * @param integer $seconds
     *
     * @return RecordInterface $this
     */
    public function setTTL($seconds)
    {
        $this->ttl = $seconds;

        return $this;
    }

    /**
     * Get Time-To-Live for the record.
     *
     * @return integer
     */
    public function getTTL()
    {
        return $this->ttl;
    }

    /**
     * Set the record priority.
     *
     * @param null|integer
     *
     * @return RecordInterface $this
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * Get the record priority.
     *
     * @return null|integer
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * Get the unique identifier for the record, based on name and type.
     *
     * @return string
     */
    public function getKey()
    {
        return md5($this->getName() . $this . $this->getPriority());
    }
}
