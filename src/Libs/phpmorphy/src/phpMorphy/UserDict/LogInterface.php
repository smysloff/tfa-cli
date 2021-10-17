<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */


interface phpMorphy_UserDict_LogInterface {
    /**
     * @param string $lexem
     */
    function addLexem($lexem);

    /**
     * @param string $lexem
     */
    function deleteLexem($lexem);

    /**
     * @param string $lexem
     */
    function editLexem($lexem);

    /**
     * @param phpMorphy_UserDict_Pattern $pattern
     * @param phpMorphy_WordForm_WordFormInterface[] $variants
     */
    function errorAmbiguity(phpMorphy_UserDict_Pattern $pattern, $variants, $isError = true);

    /**
     * @param phpMorphy_UserDict_Pattern $pattern
     */
    function errorPatternNotFound(phpMorphy_UserDict_Pattern $pattern, $isError = true);

    /**
     * @param string $patternWord
     */
    function errorCantDeduceForm($patternWord, $isError = true);

    /**
     * @param string $message
     */
    function infoMessage($message);

    /**
     * @param string $message
     */
    function errorMessage($message);
}