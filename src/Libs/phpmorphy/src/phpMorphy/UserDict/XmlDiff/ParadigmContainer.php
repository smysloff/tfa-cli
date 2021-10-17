<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */


class phpMorphy_UserDict_XmlDiff_ParadigmContainer {
    /** @var phpMorphy_Paradigm_ParadigmInterface */
    private $collection = array();

    function append(phpMorphy_Paradigm_ParadigmInterface $paradigm) {
        $this->collection[] = $paradigm;
    }

    function delete($index) {
        array_splice($this->collection, $index, 1);
    }

    function saveToMutableSource(
        phpMorphy_Dict_Source_Mutable $source,
        phpMorphy_UserDict_EncodingConverter $converter
    ) {
        $saver = new phpMorphy_UserDict_XmlDiff_ParadigmSaver($source, $converter);

        foreach($this->collection as $paradigm) {
            $saver->save($paradigm);
        }
    }

    function findWord($word, $onlyLemma = false, &$indices = null) {
        $result = array();
        $indices = array();

        $i = 0;
        /** @var phpMorphy_Paradigm_ParadigmInterface $paradigm */
        foreach($this->collection as $paradigm) {
            if(in_array($word, $paradigm->getAllForms())) {
                $result[] = $paradigm;
                $indices[] = $i;
            }
        }

        return count($result) ? $result : false;
    }
}