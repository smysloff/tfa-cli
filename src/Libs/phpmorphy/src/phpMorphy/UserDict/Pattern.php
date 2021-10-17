<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_UserDict_Pattern {
    protected
        /** @var string */
        $word,
        /** @var phpMorphy_UserDict_GrammarIdentifier */
        $grammar;

    /**
     * @param string $word
     * @param phpMorphy_UserDict_GrammarIdentifier $grammar
     */
    function __construct($word, phpMorphy_UserDict_GrammarIdentifier $grammar) {
        $this->word = $word;
        $this->grammar = $grammar;
    }

    /**
     * @param string $string
     * @return phpMorphy_UserDict_Pattern
     */
    static function constructFromString($string) {
        $string = trim($string);

        $sp_pos = strpos($string, ' ');
        $pattern = null;
        $word = $string;

        if(false !== $sp_pos) {
            $pattern_string = trim(substr($string, $sp_pos + 1));

            if(strlen($pattern_string)) {
                $pattern = phpMorphy_UserDict_GrammarIdentifier::constructFromString($pattern_string);

                $word = substr($string, 0, $sp_pos);
            }
        }

        if(null === $pattern) {
            $pattern = phpMorphy_UserDict_GrammarIdentifier::construct(null, array());
        }

        $clazz = __CLASS__;
        return new $clazz($word, $pattern);
    }

    /**
     * @return string
     */
    function getWord() {
        return $this->word;
    }

    /**
     * @return phpMorphy_UserDict_GrammarIdentifier
     */
    function getGrammarIdentifier() {
        return $this->grammar;
    }

    /**
     * @param string $word
     * @return bool
     */
    function matchWord($word) {
        return $word === $this->getWord();
    }

    /**
     * @param string $word
     * @param string $partOfSpeech
     * @param string[] $grammems
     * @return bool
     */
    function match($word, $partOfSpeech, array $grammems) {
        if(!$this->matchWord($word)) {
            return false;
        }

        return $this->getGrammarIdentifier()->match($partOfSpeech, $grammems);
    }

    /**
     * @return string
     */
    function  __toString() {
        return $this->getWord() . ' [' . $this->getGrammarIdentifier() . ']';
    }
}