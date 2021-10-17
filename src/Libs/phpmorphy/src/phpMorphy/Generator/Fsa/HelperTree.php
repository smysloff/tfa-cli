<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_Generator_Fsa_HelperTree extends phpMorphy_Generator_Fsa_HelperAbstract {
    /**
     * @return string
     */
    function getType() {
        return 'Tree';
    }

    /**
     * @return string
     */
    function checkLLast($var) {
        return "($var & 0x0200)";
    }

    /**
     * @return string
     */
    function checkRLast($var) {
        return "($var & 0x0400)";
    }

    /**
     * @return string
     */
    function getRootTransOffset() {
        return $this->getOffsetInFsa(0);
    }

    /**
     * @return string
     */
    function getAnnotIdx($var) {
        return "(($var & 0xFF) << 21) | (($var >> 11) & 0x1FFFFF)";
    }

    /**
     * @return string
     */
    function getDest($var) {
        return "(($var) >> 11) & 0x1FFFFF";
    }

    /**
     * @return string
     */
    function getIndexByTrans($transVar, $charVar) {
        return "($transVar >> 11) & 0x1FFFFF";
    }

    /**
     * @return string
     */
    function getAnnotIndexByTrans($transVar) {
        return $this->getIndexByTrans($transVar, 'Generated from ' . __FILE__ . ':' . __LINE__);
    }
}