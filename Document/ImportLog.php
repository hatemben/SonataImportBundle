<?php

namespace Sonata\ImportBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 */
class ImportLog
{
    const STATUS_SUCCESS = 1;
    const STATUS_EXISTS = 2;
    const STATUS_ERROR = 3;

    /**
     * @MongoDB\Id(strategy="auto")
     */
    private $id;

    /**
     * @MongoDB\Field(name="ts", type="date")
     */
    private $ts;

    /**
     *
     * @MongoDB\Field(name="status", type="integer")
     */
    private $status;

    /**
     *
     * @MongoDB\Field(name="message", type="string", nullable=true)
     */
    private $message;

    /**
     *
     * @MongoDB\Field(name="line", type="string")
     */
    private $line;

    /**
     *
     * @MongoDB\ReferenceOne(targetDocument="Sonata\ImportBundle\Document\UploadFile", inversedBy="importLog")
     */
    private $uploadFile;

    /**
     *
     * @MongoDB\Field(name="foreign_id", type="integer", nullable=true)
     */
    private $foreignId;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get ts
     *
     * @return \DateTime 
     */
    public function getTs()
    {
        return $this->ts;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return ImportLog
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set message
     *
     * @param string $message
     * @return ImportLog
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string 
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return mixed
     */
    public function messageEncode() {
        return json_decode($this->message);
    }

    /**
     * Set line
     *
     * @param string $line
     * @return ImportLog
     */
    public function setLine($line)
    {
        $this->line = $line;

        return $this;
    }

    /**
     * Get line
     *
     * @return string 
     */
    public function getLine()
    {
        return $this->line;
    }

    /**
     * Set uploadFile
     *
     * @param string $uploadFile
     * @return ImportLog
     */
    public function setUploadFile($uploadFile)
    {
        $this->uploadFile = $uploadFile;

        return $this;
    }

    /**
     * Get uploadFile
     *
     * @return string 
     */
    public function getUploadFile()
    {
        return $this->uploadFile;
    }


    /**
     * @MongoDB\PreUpdate()
     * @MongoDB\PrePersist()
     */
    public function prePersistUpdate() {
        $this->ts = new \DateTime();
    }

    /**
     * @param $foreignId
     * @return ImportLog
     */
    public function setForeignId($foreignId) {
        $this->foreignId = $foreignId;

        return $this;
    }

    /**
     * @return int
     */
    public function getForeignId() {
        return $this->foreignId;
    }

    /**
     * @return string
     */
    public function __toString() {
        return (string)$this->message;
    }
}
