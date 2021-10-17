<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_GramInfo_RuntimeCache extends phpMorphy_GramInfo_Decorator {
    protected
        $flexia = array();

    function readFlexiaData($info) {
        $offset = $info['offset'];

        if(!isset($this->flexia[$offset])) {
            $this->flexia[$offset] = parent::readFlexiaData($info);
        }

        return $this->flexia[$offset];
    }
}