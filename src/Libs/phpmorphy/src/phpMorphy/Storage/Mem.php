<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_Storage_Mem extends phpMorphy_Storage_StorageAbstract {
    function getType() { return phpMorphy_Storage_Factory::STORAGE_MEM; }

    function getFileSize() {
        return $GLOBALS['__phpmorphy_strlen']($this->resource);
    }

    function readUnsafe($offset, $len) {
        return $GLOBALS['__phpmorphy_substr']($this->resource, $offset, $len);
    }

    function open($fileName) {
        if(false === ($string = file_get_contents($fileName))) {
            throw new phpMorphy_Exception("Can`t read $fileName file");
        }

        return $string;
    }
}