<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_Generator_StorageHelper_Mem implements phpMorphy_Generator_StorageHelperInterface {
    /**
     * @return string
     */
    function getType() {
        return 'mem';
    }

    /**
     * @return string
     */
    function prolog() { return '$__mem = $this->resource'; }

    /**
     * @return string
     */
    function seek($offset) { return ''; }

    /**
     * @return string
     */
    function read($offset, $len) { return "\$GLOBALS['__phpmorphy_substr'](\$__mem, $offset, $len)"; }
}