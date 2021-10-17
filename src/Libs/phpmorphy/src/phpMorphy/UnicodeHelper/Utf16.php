<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_UnicodeHelper_Utf16 extends phpMorphy_UnicodeHelper_UnicodeHelperAbstract {
    protected
        $int_format_string;

    protected function __construct($encoding, $isBigEndian) {
        parent::__construct($encoding);

        $this->int_format_string = $isBigEndian ? 'n' : 'v';
    }

    function getFirstCharSize($str) {
        list(, $ord) = unpack($this->int_format_string, $str);

        return $ord >= 0xD800 && $ord <= 0xDFFF ? 4 : 2;
    }

    function strrev($str) {
        $result = array();

        $count = $GLOBALS['__phpmorphy_strlen']($str) / 2;
        $fmt = $this->int_format_string . $count;

        $words = array_reverse(unpack($fmt, $str));

        for($i = 0; $i < $count; $i++) {
            $ord = $words[$i];

            if($ord >= 0xD800 && $ord <= 0xDFFF) {
                // swap surrogates
                $t = $words[$i];
                $words[$i] = $words[$i + 1];

                $i++;
                $words[$i] = $t;
            }
        }

        array_unshift($words, $fmt);

        return call_user_func_array('pack', $words);
    }

    function clearIncompleteCharsAtEnd($str) {
        $strlen = $GLOBALS['__phpmorphy_strlen']($str);

        if($strlen & 1) {
            $strlen--;
            $str = $GLOBALS['__phpmorphy_substr']($str, 0, $strlen);
        }

        if($strlen < 2) {
            return '';
        }

        list(, $ord) = unpack($this->int_format_string, $GLOBALS['__phpmorphy_substr']($str, -2, 2));

        if($this->isSurrogate($ord)) {
            if($strlen < 4) {
                return '';
            }

            list(, $ord) = unpack($this->int_format_string, $GLOBALS['__phpmorphy_substr']($str, -4, 2));

            if($this->isSurrogate($ord)) {
                // full surrogate pair
                return $str;
            } else {
                return $GLOBALS['__phpmorphy_substr']($str, 0, -2);
            }
        }

        return $str;
    }

    protected function strlenImpl($str) {
        $count = $GLOBALS['__phpmorphy_strlen']($str) / 2;
        $fmt = $this->int_format_string . $count;

        foreach(unpack($fmt, $str) as $ord) {
            if($ord >= 0xD800 && $ord <= 0xDFFF) {
                $count--;
            }
        }

        return $count;
    }

    protected function isSurrogate($ord) {
        return $ord >= 0xD800 && $ord <= 0xDFFF;
    }
}