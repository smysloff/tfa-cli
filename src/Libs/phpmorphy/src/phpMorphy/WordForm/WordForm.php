<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */


class phpMorphy_WordForm_WordForm implements phpMorphy_WordForm_WordFormInterface {
    protected
        /** @var string */
        $common_prefix = '',
        /** @var string */
        $form_prefix = '',
        /** @var string */
        $base = '',
        /** @var string */
        $suffix = '',
        /** @var string|int */
        $part_of_speech = '',
        /** @var string[]|int[] */
        $grammems = array(),
        /** @var int */
        $common_grammems_count = 0;

    /**
     * @param phpMorphy_WordForm_WordForm|array $data
     */
    function __construct($data) {
        if(is_array($data)) {
            $this->assigmFromArray($data);
        } else if($data instanceof phpMorphy_WordForm_WordForm) {
            $this->assignFromWordForm($data);
        } else {
            throw new phpMorphy_Exception("Can`t initialize word form from '$type' type");
        }
    }

    function assigmFromArray(array $data) {
        $this->common_prefix = $data['common_prefix'];
        $this->form_prefix = $data['form_prefix'];
        $this->base = $data['base'];
        $this->suffix = $data['suffix'];
        $this->part_of_speech = $data['part_of_speech'];
        $this->grammems = array_merge($data['common_grammems'], $data['form_grammems']);
        $this->common_grammems_count = count($data['common_grammems']);
    }

    /**
     * @param phpMorphy_WordForm_WordFormInterface $wordForm
     * @return phpMorphy_WordForm_WordForm
     */
    function assignFromWordForm(phpMorphy_WordForm_WordFormInterface $wordForm) {
        $this->common_prefix = ($wordForm->getCommonPrefix());
        $this->form_prefix = ($wordForm->getFormPrefix());
        $this->base = ($wordForm->getBase());
        $this->suffix = ($wordForm->getSuffix());
        $this->part_of_speech = ($wordForm->getPartOfSpeech());
        $this->grammems = array_merge($wordForm->getCommonGrammems(), $wordForm->getFormGrammems());
        $this->common_grammems_count = count($wordForm->getCommonGrammems());

        return $this;
    }

    /**
     * @param string[] $grammems
     * @return void
     */
    function setCommonGrammems(array $grammems) {
        $this->grammems = array_merge($grammems, $this->getFormGrammems());
        $this->common_grammems_count = count($grammems);
    }

    /**
     * @param string[] $grammems
     * @return void
     */
    function setFormGrammems(array $grammems) {
        $this->grammems = array_merge($this->getCommonGrammems(), $grammems);
    }

    /**
     * @param string $partOfSpeech
     * @return void
     */
    function setPartOfSpeech($partOfSpeech) {
        $this->part_of_speech = (string)$partOfSpeech;
    }

    /**
     * @param string $suffix
     * @return void
     */
    function setSuffix($suffix) {
        $this->suffix = (string)$suffix;
    }

    /**
     * @param string $prefix
     * @return void
     */
    function setFormPrefix($prefix) {
        $this->form_prefix = (string)$prefix;
    }

    /**
     * @param string $common_prefix
     * @return void
     */
    function setCommonPrefix($common_prefix) {
        $this->common_prefix = (string)$common_prefix;
    }

    /**
     * @param string $base
     * @return void
     */
    function setBase($base) {
        $this->base = (string)$base;
    }

    /**
     * @return string
     */
    function getCommonGrammems() {
        return array_slice($this->grammems, 0, $this->common_grammems_count);
    }

    /**
     * @return string
     */
    function getFormGrammems() {
        return array_slice($this->grammems, $this->common_grammems_count);
    }

    /**
     * @return string
     */
    function getBase() {
        return $this->base;
    }

    /**
     * @return string
     */
    function getSuffix() {
        return $this->suffix;
    }

    /**
     * @return string
     */
    function getFormPrefix() {
        return $this->form_prefix;
    }

    /**
     * @return string
     */
    function getCommonPrefix() {
        return $this->common_prefix;
    }

    /**
     * @return string
     */
    function getPrefix() {
        return $this->getCommonPrefix() . $this->getFormPrefix();
    }

    /**
     * @return string[]
     */
    function getGrammems() {
        return $this->grammems;
    }

    /**
     * @return string
     */
    function getPartOfSpeech() {
        return $this->part_of_speech;
    }

    /**
     * @return string
     */
    function getWord() {
        return $this->common_prefix . $this->form_prefix . $this->base . $this->suffix;
    }

    /**
     * @param string[]|int[] $grammems
     * @return bool
     */
    function hasGrammems($grammems) {
        $grammems = (array)$grammems;

        $grammes_count = count($grammems);
        return $grammes_count && count(array_intersect($grammems, $this->getGrammems())) == $grammes_count;
    }

    /**
     * @return bool
     */
    static function compareGrammems($a, $b) {
        return count($a) == count($b) && count(array_diff($a, $b)) == 0;
    }
}