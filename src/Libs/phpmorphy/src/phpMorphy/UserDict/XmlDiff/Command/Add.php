<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */


class phpMorphy_UserDict_XmlDiff_Command_Add extends
    phpMorphy_UserDict_XmlDiff_Command_CommandAbstract
{
    const USE_COMMON_PREFIXES_FOR_NEW_LEMMA = true;

    /**
     * @param string $newLexem
     * @param phpMorphy_UserDict_Pattern $pattern
     * @param phpMorphy_UserDict_LogInterface $log
     * @return bool
     */
    function execute($newLexem, phpMorphy_UserDict_Pattern $pattern, phpMorphy_UserDict_LogInterface $log) {
        $paradigms = false;

        if(false === ($paradigms = $this->findWordMorphy($pattern->getWord()))) {
            if(false === ($paradigms = $this->findWordInternal($pattern->getWord()))) {
                $log->errorPatternNotFound($pattern);
                return false;
            }
        }

        try {
            if(false === ($form = $this->findSuitableFormByPattern($paradigms, $pattern))) {
                $log->errorPatternNotFound($pattern);
                return false;
            }
        } catch (phpMorphy_UserDict_PatternMatcher_AmbiguityException $e) {
            $log->errorAmbiguity($e->getPattern(), $e->getSuitableForms());
            return false;
        }

        $common_prefix = '';
        if(self::USE_COMMON_PREFIXES_FOR_NEW_LEMMA) {
            $common_prefix = $this->getCommonPrefixByTemplateWord($newLexem, $form);
        }

        if(false === ($base = $this->getBaseStringByTemplateWord($newLexem, $form, $common_prefix))) {
            $pattern_word = $pattern->getWord();
            $log->errorCantDeduceForm($pattern_word);
            return false;
        }

        $paradigm = new phpMorphy_Paradigm_MutableDecorator($form->getParadigm());
        $paradigm->setRetrieveAllObjectsAsMutable(true);
        foreach($paradigm as $wf) {
            $wf->setBase($base);
            $wf->setCommonPrefix($common_prefix . $wf->getCommonPrefix());
        }

        $this->appendParadigmRecursive($paradigm);

        return true;
    }

    /**
     * @param string $word
     * @param phpMorphy_WordForm_WordFormInterface $patternWord
     * @param string $additionalCommonPrefix
     * @return string
     */
    protected function getBaseStringByTemplateWord(
        $word,
        phpMorphy_WordForm_WordFormInterface $patternWord,
        $additionalCommonPrefix
    ) {
        $pattern_prefix = $patternWord->getPrefix();
        $pattern_suffix = $patternWord->getSuffix();

        $prefix = substr($word, 0, strlen($pattern_prefix));
        $suffix = $pattern_suffix !== "" ? substr($word, -strlen($pattern_suffix)) : '';

        if($prefix !== $pattern_prefix || $suffix !== $pattern_suffix) {
            return false;
        }

        $prefix_len = strlen($prefix) + strlen($additionalCommonPrefix);
        return $suffix !== "" ?
            substr($word, $prefix_len, -strlen($suffix)):
            substr($word, $prefix_len);
    }

    /**
     * @param string $word
     * @param phpMorphy_WordForm_WordFormInterface $patternWord
     * @return string
     */
    protected function getCommonPrefixByTemplateWord($word, phpMorphy_WordForm_WordFormInterface $patternWord) {
        $prefix = '';

        $possible_prefix_len = strlen($word) - strlen($patternWord->getWord());
        if(substr($word, $possible_prefix_len) === $patternWord->getWord()) {
            $prefix = substr($word, 0, $possible_prefix_len);
        }

        return $prefix;
    }
}