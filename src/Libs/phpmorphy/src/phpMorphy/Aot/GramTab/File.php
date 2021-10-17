<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_Aot_GramTab_File extends phpMorphy_Util_Collection_Immutable {
    protected $collection;

    function __construct($fileName, $encoding, phpMorphy_Aot_GramTab_GramInfoFactory $factory) {
        $this->collection = $this->createStorageCollection();

        parent::__construct($this->collection);

        $this->parse($this->createReader($fileName, $encoding, $factory));
    }

    protected function createStorageCollection() {
        return new phpMorphy_Util_Collection_ArrayBased();
    }

    protected function createReader($fileName, $encoding, phpMorphy_Aot_GramTab_GramInfoFactory $factory) {
        return new phpMorphy_Aot_GramTab_Reader($fileName, $encoding, $factory);
    }

    protected function parse(Iterator $it) {
        foreach($it as $value) {
            if(!$value instanceof phpMorphy_Aot_GramTab_GramInfo) {
                throw new phpMorphy_Aot_GramTab_Exception("Invalid value returned from reader");
            }

            $this->collection[$value->getAncodeId()] = $value;
        }
    }
}