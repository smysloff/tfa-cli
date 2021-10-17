<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

interface phpMorphy_GrammemsProvider_GrammemsProviderInterface {
    /**
     * @abstract
     * @param string $partOfSpeech
     * @return array
     */
    function getGrammems($partOfSpeech);
}