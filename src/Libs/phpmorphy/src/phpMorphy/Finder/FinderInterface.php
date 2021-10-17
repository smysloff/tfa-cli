<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

interface phpMorphy_Finder_FinderInterface {
    /**
     * @abstract
     * @param string $word
     * @return void
     */
    function findWord($word);

    /**
     * @abstract
     * @param string $raw
     * @param bool $withBase
     * @return array
     */
    function decodeAnnot($raw, $withBase);

    /**
     * @abstract
     * @return phpMorphy_AnnotDecoder_AnnotDecoderInterface
     */
    function getAnnotDecoder();
}