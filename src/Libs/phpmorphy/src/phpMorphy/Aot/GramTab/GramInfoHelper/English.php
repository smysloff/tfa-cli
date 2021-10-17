<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_Aot_GramTab_GramInfoHelper_English
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
            "NOUN" => 1,
            "VERB" => 1,
            "ADJECTIVE" => 1,
            "ADVERB" => 1,
        );

        return isset($map[$partOfSpeech]);
    }

}