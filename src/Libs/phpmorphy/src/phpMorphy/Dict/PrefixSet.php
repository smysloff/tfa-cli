<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_Dict_PrefixSet extends phpMorphy_Util_Collection_ArrayBased/*_Typed*/ {
    protected
        $id;

    function __construct($id) {
        parent::__construct(/*$this->createStorageCollection(), 'string'*/);

        $this->setId($id);
    }

    function setId($id) {
        $this->id = $id;
    }

    function getId() {
        return $this->id;
    }

    /**
     * @param bool $extendIfEmpty
     * @return string[]
     */
    function getPrefixes($extendIfEmpty = false) {
        if($extendIfEmpty && !$this->count()) {
             return array('');
        } else {
            return $this->getData();
        }
    }

    /*
    protected function createStorageCollection() {
        return new phpMorphy_Util_Collection_ArrayBased();
    }
    */

    function __toString() {
        return phpMorphy_Dict_ModelsFormatter::create()->formatPrefixSet($this);
    }
}