<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_GrammemsProvider_Empty extends phpMorphy_GrammemsProvider_GrammemsProviderAbstract {
    function getAllGrammemsGrouped() {
        return array();
    }

    function getGrammems($partOfSpeech) {
        return false;
    }
}