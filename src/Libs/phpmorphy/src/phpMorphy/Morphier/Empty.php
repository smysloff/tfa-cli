<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_Morphier_Empty implements phpMorphy_Morphier_MorphierInterface {
    function getAnnot($word) { return false; }
    function getBaseForm($word) { return false; }
    function getAllForms($word) { return false; }
    function getAllFormsWithGramInfo($word) { return false; }
    function getPseudoRoot($word) { return false; }
    function getPartOfSpeech($word) { return false; }
    function getParadigmCollection($word) { return false; }
    function getAllFormsWithAncodes($word) { return false; }
    function getAncode($word) { return false; }
    function getGrammarInfoMergeForms($word) { return false; }
    function getGrammarInfo($word) { return false; }
    function castFormByGramInfo($word, $partOfSpeech, $grammems, $returnWords = false, $callback = null) { return false; }
}