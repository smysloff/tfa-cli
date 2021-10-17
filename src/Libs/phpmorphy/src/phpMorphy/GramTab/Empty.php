<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_GramTab_Empty implements phpMorphy_GramTab_GramTabInterface {
    function getGrammems($ancodeId) { return array(); }
    function getPartOfSpeech($ancodeId) { return 0; }
    function resolveGrammemIds($ids) { return is_array($ids) ? array() : ''; }
    function resolvePartOfSpeechId($id) { return ''; }
    function includeConsts() { }
    function ancodeToString($ancodeId, $commonAncode = null) { return ''; }
    function stringToAncode($string) { return null; }
    function toString($partOfSpeechId, $grammemIds) { return ''; }
}