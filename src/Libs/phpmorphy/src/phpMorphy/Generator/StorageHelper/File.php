<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_Generator_StorageHelper_File implements phpMorphy_Generator_StorageHelperInterface {
    /**
     * @return string
     */
    function getType() {
        return 'file';
    }

    /**
     * @return string
     */
    function prolog() { return '$__fh = $this->resource'; }

    /**
     * @return string
     */
    function seek($offset) { return 'fseek($__fh, ' . $offset . ')'; }

    /**
     * @return string
     */
    function read($offset, $len) { return "fread(\$__fh, $len)"; }
}