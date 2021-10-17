<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_Storage_File extends phpMorphy_Storage_StorageAbstract  {
    function getType() { return phpMorphy_Storage_Factory::STORAGE_FILE; }

    function getFileSize() {
        if(false === ($stat = fstat($this->resource))) {
            throw new phpMorphy_Exception('Can`t invoke fstat for ' . $this->file_name . ' file');
        }

        return $stat['size'];
    }

    function readUnsafe($offset, $len) {
        if(0 !== fseek($this->resource, $offset)) {
            throw new phpMorphy_Exception("Can`t seek to $offset offset");
        }

        return fread($this->resource, $len);
    }

    function open($fileName) {
        if(false === ($fh = fopen($fileName, 'rb'))) {
            throw new phpMorphy_Exception("Can`t open $this->file_name file");
        }

        return $fh;
    }
}