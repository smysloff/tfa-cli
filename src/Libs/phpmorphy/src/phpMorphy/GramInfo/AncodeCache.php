<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_GramInfo_AncodeCache extends phpMorphy_GramInfo_Decorator {
    public
        $hits = 0,
        $miss = 0;

    protected
        $cache;

    function __construct(phpMorphy_GramInfo_GramInfoInterface $inner, $resource) {
        parent::__construct($inner);

        if(false === ($this->cache = unserialize($resource->read(0, $resource->getFileSize())))) {
            throw new phpMorphy_Exception("Can`t read ancodes cache");
        }
    }

    function readAncodes($info) {
        $offset = $info['offset'];

        if(isset($this->cache[$offset])) {
            $this->hits++;

            return $this->cache[$offset];
        } else {
            // in theory misses never occur
            $this->miss++;

            return parent::readAncodes($info);
        }
    }
}