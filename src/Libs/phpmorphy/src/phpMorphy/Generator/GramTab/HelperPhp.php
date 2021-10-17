<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_Generator_GramTab_HelperPhp {
    /**
     * @param phpMorphy_Dict_GramTab_ConstStorage $constsStorage
     * @param string $const
     * @return string
     */
    function grammemConstName(phpMorphy_Dict_GramTab_ConstStorage $constsStorage, $const) {
        return $this->constName($constsStorage, $const, 'G');
    }

    /**
     * @param phpMorphy_Dict_GramTab_ConstStorage $constsStorage
     * @param string $const
     * @return string
     */
    function posConstName(phpMorphy_Dict_GramTab_ConstStorage $constsStorage, $const) {
        return $this->constName($constsStorage, $const, 'P');
    }

    /**
     * @param phpMorphy_Dict_GramTab_ConstStorage $constsStorage
     * @param string[] $values
     * @return string
     */
    function metaGrammemConstValue(phpMorphy_Dict_GramTab_ConstStorage $constsStorage, $values) {
        foreach($values as &$value) {
            $value = $this->constName($constsStorage, $value, 'G');
        }

        return 'array(' . implode(', ', $values) . ')';
    }

    /**
     * @param phpMorphy_Dict_GramTab_ConstStorage $constsStorage
     * @param string $const
     * @param string $prefix
     * @return string
     */
    private function constName(phpMorphy_Dict_GramTab_ConstStorage $constsStorage, $const, $prefix) {
        return 'PMY_' . $constsStorage->getLanguageShort() . "{$prefix}_" . $const;
    }
}