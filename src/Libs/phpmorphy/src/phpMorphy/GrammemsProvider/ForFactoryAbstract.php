<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

abstract class phpMorphy_GrammemsProvider_ForFactoryAbstract extends phpMorphy_GrammemsProvider_GrammemsProviderAbstract {
    protected
        $encoded_grammems;

    function __construct($encoding) {
        $this->encoded_grammems = $this->encodeGrammems($this->getGrammemsMap(), $encoding);

        parent::__construct();
    }

    abstract function getGrammemsMap();

    function getAllGrammemsGrouped() {
        return $this->encoded_grammems;
    }

    protected function encodeGrammems($grammems, $encoding) {
        $from_encoding = $this->getSelfEncoding();

        if($from_encoding == $encoding) {
            return $grammems;
        }

        $result = array();

        foreach($grammems as $key => $ary) {
            $new_key = iconv($from_encoding, $encoding, $key);
            $new_value = array();

            foreach($ary as $value) {
                $new_value[] = iconv($from_encoding, $encoding, $value);
            }

            $result[$new_key] = $new_value;
        }

        return $result;
    }
}