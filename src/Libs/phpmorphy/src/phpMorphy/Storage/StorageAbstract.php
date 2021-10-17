<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

abstract class phpMorphy_Storage_StorageAbstract implements phpMorphy_Storage_StorageInterface {
    protected
        /** @var string */
        $file_name,
        /** @var mixed */
        $resource;

    /**
     * @param string $fileName
     */
    function __construct($fileName) {
        $this->file_name = (string)$fileName;
        $this->resource = $this->open($fileName);
    }

    /**
     * @return string
     */
    function getFileName() {
        return $this->file_name;
    }

    /**
     * @return mixed
     */
    function getResource() {
        return $this->resource;
    }

    /**
     * @return string
     */
    function getTypeAsString() {
        return (string)$this->getType();
    }

    /**
     * @throws phpMorphy_Exception
     * @param int $offset
     * @param int $len
     * @param bool $exactLength
     * @return string
     */
    function read($offset, $len, $exactLength = true) {
        if ($offset >= $this->getFileSize()) {
            throw new phpMorphy_Exception(
                "Can`t read $len bytes beyond end of '" . $this->getFileName()
                . "' file, offset = $offset, file_size = " . $this->getFileSize());
        }

        try {
            $result = $this->readUnsafe($offset, $len);
        } catch (Exception $e) {
            throw new phpMorphy_Exception(
                "Can`t read $len bytes at $offset offset, from '" . $this->getFileName()
                . "' file: " . $e->getMessage());
        }

        if ($exactLength && $GLOBALS['__phpmorphy_strlen']($result) < $len) {
            throw new phpMorphy_Exception(
                "Can`t read $len bytes at $offset offset, from '" . $this->getFileName()
                . "' file");
        }

        return $result;
    }

    /**
     * @abstract
     * @param int $offset
     * @param int $len
     * @return string
     */
    abstract function readUnsafe($offset, $len);

    /**
     * @abstract
     * @return string|int
     */
    abstract function getType();

    /**
     * Open $fileName and returns that resource
     * @abstract
     * @param string $fileName
     * @return mixed
     */
    abstract protected function open($fileName);
}