<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_Paradigm_CollectionSerializer {
    /**
     *
     * @param phpMorphy_Paradigm_Interface[] $collection
     * @param bool $asText
     * @return string
     */
    function serialize($collection, $asText) {
        $result = array();

        foreach($collection as $paradigm) {
            $result[] = $this->processParadigm($paradigm, $asText);
        }

        return $result;
    }

    /**
     * @param phpMorphy_Paradigm_Interface $paradigm
     * @param bool $asText
     * @return array
     */
    protected function processParadigm(phpMorphy_Paradigm_Interface $paradigm, $asText) {
        $forms = array();
        $all = array();

        foreach($paradigm as $word_form) {
            $forms[] = $word_form->getWord();
            $all[] = $this->serializeGramInfo($word_form, $asText);
        }

        return array(
            'forms' => $forms,
            'all' => $all,
            'common' => '',
        );
    }

    /**
     * @param phpMorphy_WordForm_WithFormNo $wordForm
     * @param bool $asText
     * @return array|string
     */
    protected function serializeGramInfo(phpMorphy_WordForm_WithFormNo $wordForm, $asText) {
        if($asText) {
            return $wordForm->getPartOfSpeech() . ' ' . implode(',', $wordForm->getGrammems());
        } else {
            return array(
                'pos' => $wordForm->getPartOfSpeech(),
                'grammems' => $wordForm->getGrammems()
            );
        }
    }
}