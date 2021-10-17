<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */


class phpMorphy_UserDict_PatternMatcher_AmbiguityException extends phpMorphy_UserDict_PatternMatcher_BaseException {
    /** @var phpMorphy_UserDict_Pattern  */
    private $pattern;
    /** @var phpMorphy_WordForm_WordFormInterface[] */
    private $suitable_forms = array();

    function __construct(phpMorphy_UserDict_Pattern $pattern, array $suitableForms) {
        $this->pattern = $pattern;
        $this->suitable_forms = $suitableForms;

        foreach($suitableForms as $form) {
            $descs []=
                $this->toInternalEncoding(
                    $form->getParadigm()->getBaseForm() . ' [' .
                    $form->getPartOfSpeech() . ' ' . implode(',', $form->getGrammems()) . ']'
                );
        }

        parent::__construct("An ambiguous word found: '$pattern', variants are: '" . implode("', '", $descs) . "'");
    }

    /**
     * @return phpMorphy_UserDict_Pattern
     */
    public function getPattern() {
        return $this->pattern;
    }

    /**
     * @return phpMorphy_WordForm_WordFormInterface|phpMorphy_WordForm_WordFormInterface[]
     */
    public function getSuitableForms() {
        return $this->suitable_forms;
    }
}