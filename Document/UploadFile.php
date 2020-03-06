<?php

namespace Sonata\ImportBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @MongoDB\Document
 */
class UploadFile
{

    const STATUS_LOAD = 1;
    const STATUS_SUCCESS = 2;
    const STATUS_ERROR = 3;

    /**
     * @MongoDB\Id(strategy="auto")
     */
    private $id;

    /**
     *
     * @MongoDB\Field(name="ts", type="date")
     */
    private $ts;

    /**
     * @var string
     *
     * @MongoDB\Field(name="file", type="string")
     * @var UploadedFile
     */
    private $file;

    /**
     * @var string
     *
     * @MongoDB\Field(name="encode", type="string")
     */
    private $encode;

    /**
     * @var string
     *
     * @MongoDB\Field(name="loader_class", type="string")
     */
    private $loaderClass;

    /**
     * @var string
     *
     * @MongoDB\Field(name="status", type="integer")
     */
    private $status;

    /**
     * @var string
     *
     * @MongoDB\Field(name="message", type="string", nullable=true)
     */
    private $message;

    /**
     * @MongoDB\ReferenceMany(targetDocument="Sonata\ImportBundle\Document\ImportLog", mappedBy="uploadFile")
     */
    private $importLog;


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
     * Set file
     *
     * @param string $file
     * @return UploadFile
     */
    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Get file
     *
     * @return UploadedFile|null
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @MongoDB\PrePersist()
     * @MongoDB\PreUpdate()
     */
    public function prePersistUpdate() {
        if (!$this->status) {
            $this->status = self::STATUS_LOAD;
        }
        $this->ts = new \DateTime();
    }

    /**
     * @param $encode
     * @return UploadFile
     */
    public function setEncode($encode) {
        $this->encode = $encode;

        return $this;
    }

    /**
     * @return string
     */
    public function getEncode() {
        return $this->encode;
    }

    /**
     * @param $message
     * @return UploadFile
     */
    public function setMessage($message) {
        $this->message = $message;

        return $this;
    }

    /**
     * @return string
     */
    public function getMessage() {
        return $this->message;
    }

    /**
     * @param $status
     * @return UploadFile
     */
    public function setStatus($status) {
        $this->status = $status;

        return $this;
    }

    /**
     * @return string
     */
    public function getStatus() {
        return $this->status;
    }

    /**
     * @param $loaderClass
     * @return $this
     */
    public function setLoaderClass($loaderClass) {
        $this->loaderClass = $loaderClass;

        return $this;
    }

    /**
     * @return string
     */
    public function getLoaderClass() {
        return $this->loaderClass;
    }

    public function move($uploadDir) {
        $file = $this->getFile();
        $fileName = md5(uniqid() . time()) . '.' . $file->guessExtension();
        $file->move($uploadDir, $fileName);
        $this->setFile($uploadDir . '/' . $fileName);
    }

    /**
     * @param $message
     * @return $this
     */
    public function setStatusError($message) {
        $this->setStatus(self::STATUS_ERROR);
        $this->setMessage($message);
        return $this;
    }

    /**
     * @return string
     */
    public function __toString() {
        return (string)$this->message;
    }

    /**
     * @return mixed
     */
    public function getImportLog()
    {
        return $this->importLog;
    }
}
