<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_Dict_Ancode {
    protected
        $id,
        $grammems,
        $pos,
        $is_predict;

    function __construct($id, $pos, $isPredict, $grammems = null) {
        //self::checkAncodeId($id, "Invalid ancode_id specified in ancode ctor");

        $this->grammems = new phpMorphy_Util_Collection_ArrayBased();

        if(is_string($grammems)) {
            $this->setGrammemsFromString($grammems);
        } elseif(is_array($grammems)) {
            $this->grammems->import(new ArrayIterator($grammems));
        } elseif(!is_null($grammems)) {
            throw new phpMorphy_Exception('Invalid grammems given');
        }

        $this->setId($id);
        $this->pos = $pos;
        $this->is_predict = (bool)$isPredict;
    }
/*
    static function checkAncodeId($id, $prefix) {
        if(strlen($id) != 2) {
            throw new Exception("$prefix: Ancode must be exact 2 bytes long, '$id' given");
        }
    }
*/

    function getGrammems() {
        return $this->grammems->getData();
    }

    function setGrammemsFromString($grammems, $separator = ',') {
        $this->grammems->import(new ArrayIterator(array_map('trim', explode(',', $grammems))));
    }

    function setId($id) {
        $this->id = $id;
    }

    function addGrammem($grammem) {
        $this->grammems->append($grammem);
    }

    function getId() { return $this->id; }
    function getPartOfSpeech() { return $this->pos; }
    function isPredict() { return $this->is_predict; }

    /*
    protected function createStorageCollection() {
        return new phpMorphy_Util_Collection_ArrayBased();
    }
    */

    function __toString() {
        return phpMorphy_Dict_ModelsFormatter::create()->formatAncode($this);
    }
}