<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */



interface  phpMorphy_Dict_Source_ValidatingSource_ValidatorInterface {
    function validateFlexiaId($id);
    function validateAccentId($id);
    function validateSessionId($id);
    function validatePrefixId($id);
    function validateAncodeId($id);
    function validatePartOfSpeechId($id);
    function validateGrammemId($id);
}