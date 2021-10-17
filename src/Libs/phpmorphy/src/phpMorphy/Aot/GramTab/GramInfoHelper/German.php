<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_Aot_GramTab_GramInfoHelper_German
    extends phpMorphy_Aot_GramTab_GramInfoHelperAbstract
{
    /**
     * @param string $partOfSpeech
     * @param string[] $grammems
     * @return string
     */
    function convertPartOfSpeech($partOfSpeech, $grammems) {
        return $partOfSpeech;
    }

    /**
     * @param string $partOfSpeech
     * @return bool
     */
    function isPartOfSpeechProductive($partOfSpeech) {
        static $map = array(
            "SUB" => 1,
            "VER" => 1,
            "ADJ" => 1,
            "ADV" => 1,
        );

        return isset($map[$partOfSpeech]);
    }
}