<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

interface phpMorphy_GramTab_GramTabInterface {
    /**
     * @abstract
     * @param string|int $ancodeId
     * @return string[]|int[]
     */
    function getGrammems($ancodeId);

    /**
     * @abstract
     * @param string|int $ancodeId
     * @return string|int
     */
    function getPartOfSpeech($ancodeId);

    /**
     * @abstract
     * @param string[]|int[] $ids
     * @return string[]|int[]
     */
    function resolveGrammemIds($ids);

    /**
     * @abstract
     * @param string|int $id
     * @return string|int
     */
    function resolvePartOfSpeechId($id);

    /**
     * @abstract
     * @return void
     */
    function includeConsts();

    /**
     * @abstract
     * @param string|int $ancodeId
     * @param string|int $commonAncode
     * @return string|int
     */
    function ancodeToString($ancodeId, $commonAncode = null);

    /**
     * @abstract
     * @param string $string
     * @return string|int
     */
    function stringToAncode($string);

    /**
     * @abstract
     * @param string|int $partOfSpeechId
     * @param string[]|int[] $grammemIds
     * @return string
     */
    function toString($partOfSpeechId, $grammemIds);
}