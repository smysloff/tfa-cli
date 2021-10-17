<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_Aot_GramTab_GramInfoHelper_Russian
    extends phpMorphy_Aot_GramTab_GramInfoHelperAbstract
{
    /**
     * @param string $partOfSpeech
     * @param string[] $grammems
     * @return string
     */
    function convertPartOfSpeech($partOfSpeech, $grammems) {
        if($partOfSpeech == 'Г') {
            if(in_array('прч', $grammems)) {
                return 'ПРИЧАСТИЕ';
            } elseif(in_array('дпр', $grammems)) {
                return 'ДЕЕПРИЧАСТИЕ';
            } elseif(in_array('инф', $grammems)) {
                return 'ИНФИНИТИВ';
            }
        }

        return $partOfSpeech;
    }

    /**
     * @param string $partOfSpeech
     * @return bool
     */
    function isPartOfSpeechProductive($partOfSpeech) {
        static $map = array(
            "С" => 1,
            "ИНФИНИТИВ" => 1,
            "П" => 1,
            "Н" => 1,
        );
        
        return isset($map[$partOfSpeech]);
    }

}