<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_Dict_Grammem {
    private
        $id,
        $name,
        $shift;

    function __construct($id, $name, $shift) {
        $this->id = (int)$id;
        $this->shift = (int)$shift;
        $this->name = (string)$name;
    }

    function getName() {
        return $this->name;
    }

    function getId() {
        return $this->id;
    }

    function getShift() {
        return $this->shift;
    }

    function __toString() {
        return phpMorphy_Dict_ModelsFormatter::create()->formatGrammem($this);
    }
}