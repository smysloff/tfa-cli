<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

interface phpMorphy_Morphier_MorphierInterface {
    function getAnnot($word);
    function getBaseForm($word);
    function getAllForms($word);
    function getPseudoRoot($word);
    function getPartOfSpeech($word);
    function getParadigmCollection($word);
    function getAllFormsWithAncodes($word);
    function getAncode($word);
    function getGrammarInfoMergeForms($word);
    function getGrammarInfo($word);
}