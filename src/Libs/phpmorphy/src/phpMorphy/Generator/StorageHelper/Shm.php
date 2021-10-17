<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_Generator_StorageHelper_Shm implements phpMorphy_Generator_StorageHelperInterface {
    /**
     * @return string
     */
    function getType() {
        return 'shm';
    }

    /**
     * @return string
     */
    function prolog() { return '$__shm = $this->resource[\'shm_id\']; $__offset = $this->resource[\'offset\']'; }

    /**
     * @return string
     */
    function seek($offset) { return ''; }

    /**
     * @return string
     */
    function read($offset, $len) { return "shmop_read(\$__shm, \$__offset + ($offset), $len)"; }
}