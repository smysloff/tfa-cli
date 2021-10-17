<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */



class phpMorphy_Dict_Source_ValidatingSource_Validator implements phpMorphy_Dict_Source_ValidatingSource_ValidatorInterface {
    protected
        /**
         * @var phpMorphy_Dict_Source_ValidatingSource_ValidatorSection
         */
         $flexias,
        /**
         * @var phpMorphy_Dict_Source_ValidatingSource_ValidatorSection
         */
         $accents,
        /**
         * @var phpMorphy_Dict_Source_ValidatingSource_ValidatorSection
         */
         $sessions,
        /**
         * @var phpMorphy_Dict_Source_ValidatingSource_ValidatorSection
         */
         $prefixes,
        /**
         * @var phpMorphy_Dict_Source_ValidatingSource_ValidatorSection
         */
         $ancodes,
        /**
         * @var phpMorphy_Dict_Source_ValidatingSource_ValidatorSection
         */
         $poses,
        /**
         * @var phpMorphy_Dict_Source_ValidatingSource_ValidatorSection
         */
         $grammems;

    public function __construct() {
        $this->accents = $this->createSectionValidator();
        $this->ancodes = $this->createSectionValidator();
        $this->flexias = $this->createSectionValidator();
        $this->grammems = $this->createSectionValidator();
        $this->poses = $this->createSectionValidator();
        $this->prefixes = $this->createSectionValidator();
        $this->sessions = $this->createSectionValidator();
    }

    protected function createSectionValidator() {
        return new phpMorphy_Dict_Source_ValidatingSource_ValidatorSection();
    }

    public function getPosesValidator() {
        return $this->poses;
    }

    public function getGrammemsValidator() {
        return $this->grammems;
    }

    public function getFlexiasValidator() {
        return $this->flexias;
    }

    public function getAccentsValidator() {
        return $this->accents;
    }

    public function getSessionsValidator() {
        return $this->sessions;
    }

    public function getPrefixesValidator() {
        return $this->prefixes;
    }

    public function getAncodesValidator() {
        return $this->ancodes;
    }

    function validateFlexiaId($id) { return $this->flexias->hasId($id); }
    function validateAccentId($id) { return $this->accents->hasId($id); }
    function validateSessionId($id) { return $this->sessions->hasId($id); }
    function validatePrefixId($id) { return $this->prefixes->hasId($id); }
    function validateAncodeId($id) { return $this->ancodes->hasId($id); }
    function validatePartOfSpeechId($id) {  return $this->poses->hasId($id); }
    function validateGrammemId($id) { return $this->grammems->hasId($id); }
}