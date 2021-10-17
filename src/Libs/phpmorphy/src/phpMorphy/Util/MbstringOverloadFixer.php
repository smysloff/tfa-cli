<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_Util_MbstringOverloadFixer {
    /**
     * i need byte oriented string functions
     * with namespaces support we only need overload string functions in current namespace
     * but currently use this ugly hack.
     * @param string $prefix
     * @return void
     */
    private static function exportToGlobal($prefix) {
        $GLOBALS['__phpmorphy_strlen'] = "{$prefix}strlen";
        $GLOBALS['__phpmorphy_strpos'] = "{$prefix}strpos";
        $GLOBALS['__phpmorphy_strrpos'] = "{$prefix}strrpos";
        $GLOBALS['__phpmorphy_substr'] = "{$prefix}substr";
        $GLOBALS['__phpmorphy_strtolower'] = "{$prefix}strtolower";
        $GLOBALS['__phpmorphy_strtoupper'] = "{$prefix}strtoupper";
        $GLOBALS['__phpmorphy_substr_count'] = "{$prefix}substr_count";
    }

    /**
     * @return void
     */
    static function fix() {
        if(
            extension_loaded('mbstring') &&
            2 == (ini_get('mbstring.func_overload') & 2)
        ) {
            self::exportToGlobal('mb_orig_');
        } else {
            self::exportToGlobal('');
        }
    }
}