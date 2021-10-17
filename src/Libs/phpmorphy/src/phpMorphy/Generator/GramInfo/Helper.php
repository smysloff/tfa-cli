<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_Generator_GramInfo_Helper extends phpMorphy_Generator_HelperAbstract {
    /**
     * @return string
     */
    function getParentClassName() {
        return 'phpMorphy_GramInfo_GramInfoAbstract';
    }

    /**
     * @return string
     */
    function getClassName() {
        $storage_type = ucfirst($this->storage->getType());

        return "phpMorphy_GramInfo_$storage_type";
    }

    /**
     * @return string
     */
    function prolog() {
        return $this->storage->prolog();
    }

    /**
     * @return string
     */
    function getInfoHeaderSize() {
        return 20;
    }

    /**
     * @return string
     */
    function getStartOffset() {
        return '0x100';
    }
}