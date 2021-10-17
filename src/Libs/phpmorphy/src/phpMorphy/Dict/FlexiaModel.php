<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_Dict_FlexiaModel extends phpMorphy_Util_Collection_ArrayBased/*_Typed */{
    protected
        $id;

    function __construct($id) {
        parent::__construct(/*$this->createStorageCollection(), 'phpMorphy_Dict_Flexia'*/);

        $this->setId($id);

    }
    
    function setId($id) {
        $this->id = $id;
    }

    function getId() {
        return $this->id;
    }

    function getFlexias() {
        return $this->getData();
    }

    /*
    protected function createStorageCollection() {
        return new phpMorphy_Util_Collection_ArrayBased();
    }
    */

    function __toString() {
        return phpMorphy_Dict_ModelsFormatter::create()->formatFlexiaModel($this);
    }
}