<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

interface phpMorphy_GramInfo_GramInfoInterface {
    /**
     * Returns langugage for graminfo file
     * @return string
     */
    function getLocale();

    /**
     * Return encoding for graminfo file
     * @return string
     */
    function getEncoding();

    /**
    * @return bool
    * TODO: implement this latter in dict
    */
    function isInUpperCase();

    /**
     * Return size of character
     *   (cp1251(or any single byte encoding) - 1
     *   utf8 - 1
     *   utf16 - 2
     *   utf32 - 4
     *   etc..
     * @return int
     */
    function getCharSize();

    /**
     * Return end of string value (usually string with \0 value of char_size + 1 length)
     * @return string
     */
    function getEnds();

    /**
     * Reads graminfo header
     *
     * @param int $offset
     * @return array
     */
    function readGramInfoHeader($offset);

    /**
     * Returns size of header struct
     * @return int
     */
    function getGramInfoHeaderSize();

    /**
     * Read ancodes section for header retrieved with readGramInfoHeader
     *
     * @param array $info
     * @return array
     */
    function readAncodes($info);

    /**
     * Read flexias section for header retrieved with readGramInfoHeader
     *
     * @param array $info
     * @return array
     */
    function readFlexiaData($info);

    /**
     * Read all graminfo headers offsets, which can be used latter for readGramInfoHeader method
     * @return int[]
     */
    function readAllGramInfoOffsets();

    /**
     * @abstract
     * @return array
     */
    function getHeader();

    /**
     * @abstract
     * @return array
     */
    function readAllPartOfSpeech();

    /**
     * @abstract
     * @return array
     */
    function readAllGrammems();

    /**
     * @abstract
     * @return array
     */
    function readAllAncodes();
}