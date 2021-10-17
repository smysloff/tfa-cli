<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

interface phpMorphy_AnnotDecoder_AnnotDecoderInterface {
    /**
     * @abstract
     * @param string $annotsRaw
     * @param bool $withBase
     * @return array
     */
    function decode($annotsRaw, $withBase);
}