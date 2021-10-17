<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_GramInfo_HeaderCache extends phpMorphy_GramInfo_Decorator {
    protected
        /** @var array */
        $cache,
        /** @var string */
        $ends;

    /**
     * @param phpMorphy_GramInfo_GramInfoInterface $object
     * @param string $cacheFilePath
     *
     */
    function __construct(phpMorphy_GramInfo_GramInfoInterface $object, $cacheFilePath) {
        parent::__construct($object);

        $this->cache = $this->readCache($cacheFilePath);
        $this->ends = str_repeat("\0", $this->getCharSize() + 1);
    }

    /**
     * @throws phpMorphy_Exception
     * @param string $fileName
     * @return array
     */
    private function readCache($fileName) {
        if(!is_array($result = include($fileName))) {
            throw new phpMorphy_Exception("Can`t get header cache from '$fileName' file'");
        }

        return $result;
    }

    /**
     * @return string
     */
    function getLocale()  {
        return $this->cache['lang'];
    }

    /**
     * @return string
     */
    function getEncoding()  {
        return $this->cache['encoding'];
    }

    /**
     * @return int
     */
    function getCharSize()  {
        return $this->cache['char_size'];
    }

    /**
     * @return string
     */
    function getEnds() {
        return $this->ends;
    }

    /**
     * @return array
     */
    function getHeader() {
        return $this->cache;
    }
}