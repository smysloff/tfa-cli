<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */


class phpMorphy_UserDict_EditCommand_Delete extends phpMorphy_UserDict_EditCommand_CommandAbstract {
    /** @var phpMorphy_UserDict_Pattern */
    protected $pattern;

    /**
     * @param phpMorphy_UserDict_Pattern $pattern
     * @return phpMorphy_UserDict_EditCommand_Delete
     */
    function __construct(
        phpMorphy_UserDict_PatternMatcher $matcher,
        phpMorphy_UserDict_Pattern $pattern
    ) {
        parent::__construct($matcher);
        
        $this->pattern = $pattern;
    }

    /**
     * @param phpMorphy_Paradigm_MutableDecorator $paradigm
     * @return void
     */
    function apply(phpMorphy_Paradigm_MutableDecorator $paradigm) {
        list($forms, $indices) = $this->pattern_matcher->findSuitableFormsByPattern(
            array($paradigm),
            $this->pattern,
            false
        );

        foreach($indices as $idx) {
            $paradigm->deleteWordForm($idx);
        }

        $paradigm->updateBases();
    }
}