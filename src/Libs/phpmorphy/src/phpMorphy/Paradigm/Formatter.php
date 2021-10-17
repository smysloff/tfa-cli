<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */



class phpMorphy_Paradigm_Formatter {
    const COMMON_PREFIX_SEPARATOR = '|';
    const PREFIX_SEPARATOR = '<';
    const SUFFIX_SEPARATOR = '>';
    const COMMON_GRAMMEMS_SEPARATOR = '|';

    static function create() {
        return new phpMorphy_Paradigm_Formatter();
    }

    function format(phpMorphy_Paradigm_ParadigmInterface $paradigm, $indent = '') {
        ob_start();

        try {
            $form_no = 1;
            foreach($paradigm as $word_form) {
                echo $indent, sprintf("%3d. ", $form_no++);
                $this->printWordForm($word_form);
                echo PHP_EOL;
            }
        } catch (Exception $e) {
            ob_end_clean();
            throw $e;
        }

        return ob_get_clean();
    }

    function printWordForm(phpMorphy_WordForm_WordFormInterface $form) {
        echo
            $form->getWord() , ' [',
            $form->getCommonPrefix() , self::COMMON_PREFIX_SEPARATOR,
            $form->getPrefix() , self::PREFIX_SEPARATOR,
            $form->getBase() , self::SUFFIX_SEPARATOR,
            $form->getSuffix(),
            '] (',
            $form->getPartOfSpeech() , ' ',
            implode(',', $form->getCommonGrammems()) , self::COMMON_GRAMMEMS_SEPARATOR,
            implode(',', $form->getFormGrammems()),
            ')';
    }
}