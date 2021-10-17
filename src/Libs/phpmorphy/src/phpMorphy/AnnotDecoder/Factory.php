<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_AnnotDecoder_Factory {
    protected static $instances = array();

    protected
        $cache_common,
        $cache_predict,
        $eos;

    protected function __construct($eos) {
        $this->eos = $eos;
    }

    /**
     * @param string $eos
     * @return phpMorphy_AnnotDecoder_Factory
     */
    static function instance($eos) {
        if(!isset(self::$instances[$eos])) {
            self::$instances[$eos] = new phpMorphy_AnnotDecoder_Factory($eos);
        }

        return self::$instances[$eos];
    }

    function getCommonDecoder() {
        if(!isset($this->cache_common)) {
            $this->cache_common = new phpMorphy_AnnotDecoder_Common($this->eos);
        }

        return $this->cache_common;
    }

    function getPredictDecoder() {
        if(!isset($this->cache_predict)) {
            $this->cache_predict = new phpMorphy_AnnotDecoder_Predict($this->eos);
        }

        return $this->cache_predict;
    }
}