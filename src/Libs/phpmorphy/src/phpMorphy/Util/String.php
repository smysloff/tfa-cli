<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_Util_String {
    /**
     * Returns longest common substring among all strings
     * @param string[] $stringsArray
     * @param bool $isUtf
     * @param string $separatorChar
     * @return string|false
     */
    static function getLongestCommonSubstring(array $stringsArray, $isUtf8 = true, $separatorChar = "\0") {
        $strings_count = count($stringsArray);

        if($strings_count < 2) {
            return false;
        }

        $reg_modifiers = $isUtf8 ? "u" : '';
        $reg_format = '/(.{%d})' .
                      str_repeat('.*\x00.*\1', $strings_count - 1) .
                      "/$reg_modifiers";

        $lcs = false;
        $merged_strings = implode($separatorChar, $stringsArray);

        for($i = 1, $c = strlen($stringsArray[0]); $i < $c; $i++) {
            if(!preg_match(sprintf($reg_format, $i), $merged_strings, $matches)) {
                break;
            }

            $lcs = $matches[1];
        }

        return $lcs;
    }
}