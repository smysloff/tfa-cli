<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_Shm_FileDescriptor {
    private
        $shm_id,
        $file_size,
        $offset;

    function __construct($shmId, $fileSize, $offset) {
        $this->shm_id = $shmId;
        $this->file_size = $fileSize;
        $this->offset = $offset;
    }

    function getShmId() { return $this->shm_id; }
    function getFileSize() { return $this->file_size; }
    function getOffset() { return $this->offset; }
}