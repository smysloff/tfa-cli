<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

interface phpMorphy_Storage_StorageInterface {
    /**
     * Returns name of file
     * @return string
     */
    function getFileName();

    /**
     * Returns size of file in bytes
     * @abstract
     * @return int
     */
    function getFileSize();

    /**
     * Returns resource of this storage
     * @return mixed
     */
    function getResource();

    /**
     * Returns type of this storage
     * @return string
     */
    function getTypeAsString();

    /**
     * Reads $len bytes from $offset offset
     *
     * @throws phpMorphy_Exception
     * @param int $offset Read from this offset
     * @param int $length How many bytes to read
     * @param bool $exactLength If this set to true, then exception thrown when we read less than $len bytes
     * @return string
     */
    function read($offset, $length, $exactLength = true);
}