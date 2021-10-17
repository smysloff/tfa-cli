<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_Aot_GramTab_GramInfo {

    protected
        /** @var bool */
        $is_predict,
        /** @var string */
        $ancode_id,
        /** @var string */
        $pos,
        /** @var string[] */
        $grammems;

    /**
     * @param string|null $partOfSpeech
     * @param string[] $grammems
     * @param string $ancodeId
     * @param bool $isPredict
     *
     */
    function __construct($partOfSpeech, $grammems, $ancodeId, $isPredict) {
/*
        if(strlen($ancode) != 2) {
            throw new phpMorphy_Aot_GramTab_Exception("Invalid ancode '$ancode' given, ancode length must be 2 bytes long");
        }
*/

        $this->ancode_id = $ancodeId;
        $this->pos = $partOfSpeech;
        $this->is_predict = (bool)$isPredict;

        $this->grammems = (array)$grammems;
    }

    function getPartOfSpeech() {
        return $this->pos;
    }

    function getPartOfSpeechLong() {
        return $this->pos;
    }

    function getAncodeId() {
        return $this->ancode_id;
    }

    function getGrammems() {
        return $this->grammems;
    }

    function isPartOfSpeechProductive() {
        return $this->is_predict;
    }
};