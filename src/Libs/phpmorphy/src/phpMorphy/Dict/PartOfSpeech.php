<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_Dict_PartOfSpeech {
    private
        $id,
        $name,
        $is_predict;

    function __construct($id, $name, $isPredict) {
        $this->id = (int)$id;
        $this->is_predict = (bool)$isPredict;
        $this->name = (string)$name;
    }

    function getName() {
        return $this->name;
    }

    function getId() {
        return $this->id;
    }

    function isPredict() {
        return $this->is_predict;
    }

    function __toString() {
        return phpMorphy_Dict_ModelsFormatter::create()->formatPartOfSpeech($this);
    }
}