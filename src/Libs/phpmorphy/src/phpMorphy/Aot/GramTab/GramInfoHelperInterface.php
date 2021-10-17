<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

interface phpMorphy_Aot_GramTab_GramInfoHelperInterface {
    /**
     * @param string $partOfSpeech
     * @param string[] $grammems
     * @return string
     */
    function convertPartOfSpeech($partOfSpeech, $grammems);

    /**
     * @param string $partOfSpeech
     * @return bool
     */
    function isPartOfSpeechProductive($partOfSpeech);
}