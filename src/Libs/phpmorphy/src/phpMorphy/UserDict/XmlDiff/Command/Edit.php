<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */




class phpMorphy_UserDict_XmlDiff_Command_Edit {
    /** @var phpMorphy_UserDict_Pattern */
    protected $pattern;
    /** @var phpMorphy_UserDict_EditCommand_CommandAbstract[] */
    protected $commands = array();

    /**
     * @param phpMorphy_UserDict_Pattern $pattern
     * @return phpMorphy_UserDict_XmlDiff_Command_Edit
     */
    public function setPattern(phpMorphy_UserDict_Pattern $pattern) {
        $this->pattern = $pattern;
        return $this;
    }

    /**
     * @return phpMorphy_UserDict_Pattern
     */
    public function getPattern() {
        return $this->pattern;
    }

    /**
     * @param phpMorphy_UserDict_EditCommand_CommandAbstract $command
     * @return phpMorphy_UserDict_XmlDiff_Command_Edit
     */
    public function appendCommand(phpMorphy_UserDict_EditCommand_CommandAbstract $command) {
        $this->commands[] = $command;
        return $this;
    }

    /**
     * @param phpMorphy_Paradigm_MutableDecorator $paradigm
     * @return phpMorphy_Paradigm_MutableDecorator
     */
    public function apply(phpMorphy_Paradigm_MutableDecorator $paradigm) {
        foreach($this->commands as $command) {
            $command->apply($paradigm);
        }

        return $paradigm;
    }
}