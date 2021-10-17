<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_Storage_Shm extends phpMorphy_Storage_StorageAbstract {
    protected
        $descriptor;

    function __construct($fileName, $shmCache) {
        $this->cache = $shmCache;

        parent::__construct($fileName);
    }

    function getFileSize() {
        return $this->descriptor->getFileSize();
    }

    function getType() { return phpMorphy_Storage_Factory::STORAGE_SHM; }

    function readUnsafe($offset, $len) {
        return shmop_read($this->resource['shm_id'], $this->resource['offset'] + $offset, $len);
    }

    function open($fileName) {
        $this->descriptor = $this->cache->get($fileName);

        return array(
            'shm_id' => $this->descriptor->getShmId(),
            'offset' => $this->descriptor->getOffset()
        );
    }
}