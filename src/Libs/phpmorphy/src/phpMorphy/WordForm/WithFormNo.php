<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */


class phpMorphy_WordForm_WithFormNo extends phpMorphy_WordForm_WordForm {
    /** @var int */
    protected $form_no;

    /**
     * @param int $form_no
     */
    function __construct($form_no) {
        $this->form_no = (int)$form_no;
    }

    function getFormNo() {
        return $this->form_no;
    }
}