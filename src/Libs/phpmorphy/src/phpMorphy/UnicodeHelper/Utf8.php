<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_UnicodeHelper_Utf8 extends phpMorphy_UnicodeHelper_UnicodeHelperAbstract {
    protected static $TAILS_LENGTH_MAP = array(
        0,0,0,0,0,0,0,0, 0,0,0,0,0,0,0,0,
        0,0,0,0,0,0,0,0, 0,0,0,0,0,0,0,0,
        0,0,0,0,0,0,0,0, 0,0,0,0,0,0,0,0,
        0,0,0,0,0,0,0,0, 0,0,0,0,0,0,0,0,
        0,0,0,0,0,0,0,0, 0,0,0,0,0,0,0,0,
        0,0,0,0,0,0,0,0, 0,0,0,0,0,0,0,0,
        0,0,0,0,0,0,0,0, 0,0,0,0,0,0,0,0,
        0,0,0,0,0,0,0,0, 0,0,0,0,0,0,0,0,
        0,0,0,0,0,0,0,0, 0,0,0,0,0,0,0,0,
        0,0,0,0,0,0,0,0, 0,0,0,0,0,0,0,0,
        0,0,0,0,0,0,0,0, 0,0,0,0,0,0,0,0,
        0,0,0,0,0,0,0,0, 0,0,0,0,0,0,0,0,
        1,1,1,1,1,1,1,1, 1,1,1,1,1,1,1,1,
        1,1,1,1,1,1,1,1, 1,1,1,1,1,1,1,1,
        2,2,2,2,2,2,2,2, 2,2,2,2,2,2,2,2,
        3,3,3,3,3,3,3,3, 4,4,4,4,5,5,0,0
    );

    function getFirstCharSize($str) {
        return 1 + self::$TAILS_LENGTH_MAP[ord($str[0])];
    }

    function strrev($str) {
        preg_match_all('/./us', $str, $matches);
        return implode('', array_reverse($matches[0]));
        /*
        $result = array();

        for($i = 0, $c = $GLOBALS['__phpmorphy_strlen']($str); $i < $c;) {
            $len = 1 + $this->tails_length[ord($str[$i])];

            $result[] = $GLOBALS['__phpmorphy_substr']($str, $i, $len);

            $i += $len;
        }

        return implode('', array_reverse($result));
        */
    }

    function clearIncompleteCharsAtEnd($str) {
        $strlen = $GLOBALS['__phpmorphy_strlen']($str);

        if(!$strlen) {
            return '';
        }

        $ord = ord($str[$strlen - 1]);

        if(($ord & 0x80) == 0) {
            return $str;
        }

        for($i = $strlen - 1; $i >= 0; $i--) {
            $ord = ord($str[$i]);

            if(($ord & 0xC0) == 0xC0) {
                $diff = $strlen - $i;
                $seq_len = self::$TAILS_LENGTH_MAP[$ord] + 1;

                $miss = $seq_len - $diff;

                if($miss) {
                    return $GLOBALS['__phpmorphy_substr']($str, 0, -($seq_len - $miss));
                } else {
                    return $str;
                }
            }
        }

        return '';
    }

    protected function strlenImpl($str) {
        preg_match_all('/./us', $str, $matches);
        return count($matches[0]);
    }
}