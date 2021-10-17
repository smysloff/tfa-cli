<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */


abstract class phpMorphy_UserDict_EditCommand_CommandAbstract {
    /** @var phpMorphy_UserDict_PatternMatcher */
    protected $pattern_matcher;

    function __construct(phpMorphy_UserDict_PatternMatcher $matcher) {
        $this->pattern_matcher = $matcher;
    }

    /**
     * @param phpMorphy_Paradigm_MutableDecorator $paradigm
     * @return void
     */
    abstract function apply(phpMorphy_Paradigm_MutableDecorator $paradigm);
}