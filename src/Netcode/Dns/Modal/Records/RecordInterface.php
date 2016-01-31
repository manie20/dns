<?php

namespace Netcode\Dns\Modal\Records;

/**
 * Define the default functionality a single DNS Zone record should contain.
 */
interface RecordInterface
{
    /**
     * Set record name.
     *
     * @param $name
     *
     * @return RecordInterface $this
     */
    public function setName($name);

    /**
     * Get record name.
     *
     * @return string
     */
    public function getName();

    /**
     * Set type of Zone record.
     *
     * @param RecordInterface $type
     *
     * @return RecordInterface $this
     */
    public function setType(RecordInterface $type);

    /**
     * Get type of record.
     *
     * @return RecordInterface
     */
    public function getType();

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
     * Set record content.
     *
     * @param string $content
     *
     * @return RecordInterface $this
     */
    public function setContent($content);

    /**
     * Get content for the record.
     *
     * @return string
     */
    public function getContent();

    /**
     * Set Time-To-Live in seconds.
     *
     * @param integer $seconds
     *
     * @return RecordInterface $this
     */
    public function setTTL($seconds);

    /**
     * Get Time-To-Live for the record.
     *
     * @return integer
     */
    public function getTTL();

    /**
     * Set the record priority.
     *
     * @param null|integer
     *
     * @return RecordInterface $this
     */
    public function setPriority($priority);

    /**
     * Get the record priority.
     *
     * @return null|integer
     */
    public function getPriority();

    /**
     * Get the unique identifier for the record, based on name and type.
     *
     * @return string
     */
    public function getKey();
}
