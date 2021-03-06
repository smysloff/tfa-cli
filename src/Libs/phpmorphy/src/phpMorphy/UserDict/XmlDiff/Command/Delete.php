<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */


class phpMorphy_UserDict_XmlDiff_Command_Delete extends
    phpMorphy_UserDict_XmlDiff_Command_CommandAbstract
{
    const USE_COMMON_PREFIXES_FOR_NEW_LEMMA = true;

    /** @var string|int */
    private $part_of_speech_for_deleted;

    /**
     * @param phpMorphy_UserDict_Pattern $pattern
     * @param bool $deleteFromInternal
     * @param bool $deleteFromExternal
     * @param phpMorphy_UserDict_LogInterface $log
     * @return bool
     */
    function execute(
        phpMorphy_UserDict_Pattern $pattern,
        $deleteFromInternal,
        $deleteFromExternal,
        phpMorphy_UserDict_LogInterface $log
    ) {
        $internal_deleted = $deleteFromInternal && $this->deleteLexemInternal($pattern, $log);
        $external_deleted = $deleteFromExternal && $this->deleteLexemExternal($pattern, $log);

        if(!($internal_deleted || $external_deleted) && ($deleteFromInternal || $deleteFromInternal)) {
            $log->errorPatternNotFound($pattern, false);
        }

        return true;
    }

    /**
     * @param phpMorphy_UserDict_Pattern $pattern
     * @return bool
     */
    protected function deleteLexemExternal(
        phpMorphy_UserDict_Pattern $pattern,
        phpMorphy_UserDict_LogInterface $log
    ) {
        if(false === ($paradigms = $this->findWordMorphy($pattern->getWord()))) {
            return false;
        }

        try {
            if(false === ($form = $this->findSuitableFormByPattern($paradigms, $pattern, false))) {
                return false;
            }
        } catch (phpMorphy_UserDict_PatternMatcher_AmbiguityException $e) {
            $log->errorAmbiguity($e->getPattern(), $e->getSuitableForms());
            return false;
        }

        $pos = $this->getPartOfSpeechForDeletedWordForm();

        $morphy_paradigm = $form->getParadigm();
        $fixed_pos_paradigm = new phpMorphy_Paradigm_MutableDecorator(
            $morphy_paradigm,
            function($wordForm) use ($pos) {
                $obj = new phpMorphy_WordForm_MonkeyDecorator($wordForm);
                $obj->overrideMethod(
                    'getPartOfSpeech',
                    function($inner) use ($pos) {
                        return $pos;
                    }
                );

                return $obj;
            }
        );

        $ignore_paradigms = array($morphy_paradigm->getHash() => true);
        $this->appendParadigmRecursive($fixed_pos_paradigm, $ignore_paradigms);

        return true;
    }

    /**
     * @param phpMorphy_UserDict_Pattern $pattern
     * @return bool
     */
    protected function deleteLexemInternal(
        phpMorphy_UserDict_Pattern $pattern,
        phpMorphy_UserDict_LogInterface $log
    ) {
        $para_indeces = null;
        if(false === ($paradigms = $this->findWordInternal($pattern->getWord(), $para_indeces))) {
            return false;
        }

        $form_index = null;
        try {
            if(false === ($form = $this->findSuitableFormByPattern($paradigms, $pattern, $form_index))) {
                return false;
            }
        } catch (phpMorphy_UserDict_PatternMatcher_AmbiguityException $e) {
            $log->errorAmbiguity($e->getPattern(), $e->getSuitableForms());
            return false;
        }

        $this->paradigms_container->delete($para_indeces[$form_index]);

        return true;
    }

    /**
     * @return string|int
     */
    protected function getPartOfSpeechForDeletedWordForm() {
        if(null === $this->part_of_speech_for_deleted) {
            $helper = phpMorphy_Dict_GramTab_ConstStorage_Factory::getSpecials();
            $this->part_of_speech_for_deleted = $helper->getDeletedTagName();
        }

        return $this->part_of_speech_for_deleted;
    }
}