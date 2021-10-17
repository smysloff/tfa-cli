<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_Shm_Header {
    protected
        $max_size,
        $segment_id,
        $files_map = array(),
        $free_map = array();

    function __construct($segmentId, $maxSize) {
        $this->max_size = (int)$maxSize;
        $this->segment_id = $segmentId;

        $this->clear();
    }

    function lookup($filePath) {
        if(!$this->exists($filePath)) {
            throw new phpMorphy_Exception("'$filePath' not found in shm");
        }

        return $this->files_map[$this->normalizePath($filePath)];
    }

    function exists($filePath) {
        return isset($this->files_map[$this->normalizePath($filePath)]);
    }

    function register($filePath, $fh) {
        if($this->exists($filePath)) {
            throw new phpMorphy_Exception("Can`t register, '$filePath' already exists");
        }

        if(false === ($stat = fstat($fh))) {
            throw new phpMorphy_Exception("Can`t fstat '$filePath' file");
        }

        $file_size = $stat['size'];

        $offset = $this->getBlock($file_size);

        $entry = array(
            'offset' => $offset,
            'mtime' => $stat['mtime'],
            'size' => $file_size,
            'shm_id' => $this->segment_id
        );

        $this->files_map[$this->normalizePath($filePath)] = $entry;

        return $entry;
    }

    function delete($filePath) {
        $data = $this->lookup($filePath);

        unset($this->files_map[$this->normalizePath($filePath)]);

        $this->freeBlock($data['offset'], $data['size']);
    }

    function clear() {
        $this->files_map = array();
        $this->free_map = array(0 => $this->max_size);
    }

    function getAllFiles() {
        return $this->files_map;
    }

    protected function registerBlock($offset, $size) {
        $old_size = $this->free_map[$offset];

        if($old_size < $size) {
            throw new phpMorphy_Exception("Too small free block for register(free = $old_size, need = $size)");
        }

        unset($this->free_map[$offset]);

        if($old_size > $size) {
            $this->free_map[$offset + $size] = $old_size - $size;
        }
    }

    protected function freeBlock($offset, $size) {
        $this->free_map[$offset] = $size;
        $this->defrag();
    }

    protected function defrag() {
        ksort($this->free_map);

        $map_count = count($this->free_map);

        if($map_count < 2) {
            return;
        }

        $keys = array_keys($this->free_map);
        $i = 0;
        $prev_offset = $keys[$i];

        for($i++; $i < $map_count; $i++) {
            $offset = $keys[$i];

            if($prev_offset + $this->free_map[$prev_offset] == $offset) {
                // merge
                $this->free_map[$prev_offset] += $this->free_map[$offset];

                unset($this->free_map[$offset]);
            } else {
                $prev_offset = $offset;
            }
        }
    }

    protected function getBlock($fileSize) {
        foreach($this->free_map as $offset => $size) {
            if($size >= $fileSize) {
                $this->registerBlock($offset, $fileSize);

                return $offset;
            }
        }

        throw new phpMorphy_Exception("Can`t find free space for $size block");
    }

    protected function normalizePath($path) {
        return $path;
    }
}