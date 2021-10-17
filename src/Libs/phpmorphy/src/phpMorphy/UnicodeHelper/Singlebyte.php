<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_UnicodeHelper_Singlebyte extends phpMorphy_UnicodeHelper_UnicodeHelperAbstract {
    function getFirstCharSize($str) {
        return 1;
    }

    function strrev($str) {
        return strrev($str);
    }

    function clearIncompleteCharsAtEnd($str) {
        return $str;
    }

    protected function strlenImpl($str) {
        return $GLOBALS['__phpmorphy_strlen']($str);
    }
}