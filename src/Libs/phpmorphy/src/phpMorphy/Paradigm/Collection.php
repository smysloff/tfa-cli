<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_Paradigm_Collection extends phpMorphy_Util_Collection_Typed {
    function __construct() {
        parent::__construct(
            new phpMorphy_Util_Collection_ArrayBased(),
            'phpMorphy_Paradigm_ParadigmInterface'
        );
    }

    /**
     * @param string|string[] $poses
     * @return phpMorphy_Paradigm_ParadigmInterface[]
     */
    function getByPartOfSpeech($poses) {
        $result = array();
        settype($poses, 'array');

        foreach($this as $paradigm) {
            if($paradigm->hasPartOfSpeech($poses)) {
                $result[] = $paradigm;
            }
        }

        return $result;
    }
}
