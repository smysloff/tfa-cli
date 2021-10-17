<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */


interface phpMorphy_WordForm_WordFormInterface {
    /**
     * @return string
     */
    function getWord();

    /**
     * @return string
     */
    function getPartOfSpeech();

    /**
     * @return string[]
     */
    function getGrammems();

    /**
     * @return string
     */
    function getCommonPrefix();

    /**
     * @return string
     */
    function getFormPrefix();

    /**
     * @return string
     */
    function getSuffix();

    /**
     * @return string
     */
    function getBase();

    /**
     * @return string
     */
    function getFormGrammems();

    /**
     * @return string
     */
    function getCommonGrammems();

    /**
     * @return string
     */
    function getPrefix();

    /**
     * @param string[]|int[]|string|int $grammems
     * @return bool
     */
    function hasGrammems($grammems);

    /**
     * @abstract
     * @param string $base
     * @return void
     */
    function setBase($base);

    /**
     * @abstract
     * @param string $common_prefix
     * @return void
     */
    function setCommonPrefix($common_prefix);

    /**
     * @abstract
     * @param string $prefix
     * @return void
     */
    function setFormPrefix($prefix);

    /**
     * @abstract
     * @param string $suffix
     * @return void
     */
    function setSuffix($suffix);

    /**
     * @abstract
     * @param string $partOfSpeech
     * @return void
     */
    function setPartOfSpeech($partOfSpeech);

    /**
     * @abstract
     * @param string[] $grammems
     * @return void
     */
    function setFormGrammems(array $grammems);

    /**
     * @abstract
     * @param string[] $grammems
     * @return void
     */
    function setCommonGrammems(array $grammems);
}