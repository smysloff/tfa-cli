<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

abstract class phpMorphy_Finder_FinderAbstract implements phpMorphy_Finder_FinderInterface {
    protected
        /** @var phpMorphy_AnnotDecoder_AnnotDecoderInterface */
        $annot_decoder,
        /** @var string */
        $prev_word,
        /** @var array */
        $prev_result = false;

    /**
     * @param phpMorphy_AnnotDecoder_AnnotDecoderInterface $annotDecoder
     */
    function __construct(phpMorphy_AnnotDecoder_AnnotDecoderInterface $annotDecoder) {
        $this->annot_decoder = $annotDecoder;
    }

    /**
     * @param string $word
     * @return array
     */
    function findWord($word) {
        if($this->prev_word === $word) {
            return $this->prev_result;
        }

        $result = $this->doFindWord($word);

        $this->prev_word = $word;
        $this->prev_result = $result;

        return $result;
    }

    /**
     * @return phpMorphy_AnnotDecoder_AnnotDecoderInterface
     */
    function getAnnotDecoder() {
        return $this->annot_decoder;
    }

    /**
     * @param string $raw
     * @param bool $withBase
     * @return array
     */
    function decodeAnnot($raw, $withBase) {
        return $this->annot_decoder->decode($raw, $withBase);
    }

    /**
     * @abstract
     * @param string $word
     * @return array
     */
    abstract protected function doFindWord($word);
}