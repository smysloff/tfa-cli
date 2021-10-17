<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */


class phpMorphy_UserDict_PatternMatcher {
    /**
     * @param phpMorphy_Paradigm_ParadigmInterface[] $paradigms
     * @param phpMorphy_UserDict_Pattern $pattern
     * @param bool $isMatchOnlyLemmas
     * @param void &$formIndex
     * @return phpMorphy_WordForm_WordFormInterface
     */
    function findSuitableFormByPattern(
        $paradigms,
        phpMorphy_UserDict_Pattern $pattern,
        $isMatchOnlyLemmas,
        &$formIndex = null
    ) {
        list($suitable_forms, $forms_idx) = $this->findSuitableFormsByPattern(
            $paradigms,
            $pattern,
            $isMatchOnlyLemmas
        );

        $forms_count = count($suitable_forms);

        if($forms_count > 1) {
            throw new phpMorphy_UserDict_PatternMatcher_AmbiguityException($pattern, $suitable_forms);
        }

        if($forms_count == 1) {
            $formIndex = $forms_idx[0];
            return $suitable_forms[0];
        } else {
            return false;
        }
    }

    /**
     * @param phpMorphy_Paradigm_ParadigmInterface[] $paradigmsCollection
     * @param phpMorphy_UserDict_Pattern $pattern
     * @param bool $isMatchOnlyLemmas
     * @return array(0 => phpMorphy_WordForm_WordFormAbstract[], 1 => int[])
     */
    function findSuitableFormsByPattern(
        $paradigmsCollection,
        phpMorphy_UserDict_Pattern $pattern,
        $isMatchOnlyLemmas
    ) {
        $result = array();
        $forms_idx = array();

        foreach($paradigmsCollection as $paradigm) {
            if($isMatchOnlyLemmas) {
                $lemma = $paradigm->getLemma();

                if($pattern->matchWord($lemma)) {
                    $word_form = $paradigm->getWordForm(0);

                    $match_result = $pattern->match(
                        $word_form->getWord(),
                        $word_form->getPartOfSpeech(),
                        $word_form->getGrammems()
                    );

                    if($match_result) {
                        $result[] = $word_form;
                        $forms_idx[] = 0;
                    }
                }
            } else {
                $form_no = 0;
                foreach($paradigm as $word_form) {
                    $match_result = $pattern->match(
                        $word_form->getWord(),
                        $word_form->getPartOfSpeech(),
                        $word_form->getGrammems()
                    );

                    if($match_result) {
                        $result[] = $word_form;
                        $forms_idx[] = $form_no;
                    }

                    $form_no++;
                }
            }
        }

        return array($result, $forms_idx);
    }
}