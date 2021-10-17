<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */



class phpMorphy_Dict_Source_ValidatingSource_ValidatorSection implements Countable{
    protected $map = array();

    function insertId($id) {
        if($this->hasId($id)) {
            return true;
        }

        $this->map[$id] = true;
        return false;
    }

    function hasId($id) {
        return isset($this->map[$id]);
    }

    public function count() {
        return count($this->map);
    }
}