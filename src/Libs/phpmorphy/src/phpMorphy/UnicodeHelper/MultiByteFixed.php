<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_UnicodeHelper_MultiByteFixed extends phpMorphy_UnicodeHelper_UnicodeHelperAbstract {
    protected
        $char_size;

    protected function __construct($encoding, $charSize) {
        parent::__construct($encoding);
        $this->char_size = (int)$charSize;
    }

    function getFirstCharSize($str) {
        return $this->char_size;
    }

    function strrev($str) {
        return implode('', array_reverse(str_split($str, $this->char_size)));
    }

    protected function strlenImpl($str) {
        return $GLOBALS['__phpmorphy_strlen']($str) / $this->char_size;
    }

    function clearIncompleteCharsAtEnd($str) {
        $len = $GLOBALS['__phpmorphy_strlen']($str);
        $mod = $len % $this->char_size;

        if($mod > 0) {
            //return $GLOBALS['__phpmorphy_substr']($str, 0, floor($len / $this->size) * $this->size);
            return $GLOBALS['__phpmorphy_substr']($str, 0, $len - $mod);
        }

        return $str;
    }
}