<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_Generator_Fsa_HelperSparse extends phpMorphy_Generator_Fsa_HelperAbstract {
    /**
     * @return string
     */
    function getType() {
        return 'Sparse';
    }

    /**
     * @return string
     */
    function checkEmpty($var) {
        return "($var & 0x0200)";
    }

    /**
     * @return string
     */
    function getRootTransOffset() {
        return $this->getOffsetInFsa($this->getTransSize());
    }

    /**
     * @return string
     */
    function getDest($var) {
        return "(($var) >> 10) & 0x3FFFFF";
    }

    /**
     * @return string
     */
    function getAnnotIdx($var) {
        return "(($var & 0xFF) << 22) | (($var >> 10) & 0x3FFFFF)";
    }

    /**
     * @return string
     */
    function getIndexByTrans($transVar, $charVar) {
        return "(($transVar >> 10) & 0x3FFFFF) + $charVar + 1";
    }

    /**
     * @return string
     */
    function getAnnotIndexByTrans($transVar) {
        return "($transVar >> 10) & 0x3FFFFF";
    }
}