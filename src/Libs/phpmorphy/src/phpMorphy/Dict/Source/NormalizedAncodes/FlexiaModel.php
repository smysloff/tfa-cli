<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */


class phpMorphy_Dict_Source_NormalizedAncodes_FlexiaModel extends phpMorphy_Dict_FlexiaModelDecorator {
    protected $manager;

    function __construct(phpMorphy_Dict_Source_NormalizedAncodes_AncodesManager $manager, phpMorphy_Dict_FlexiaModel $inner) {
        parent::__construct($inner);
        $this->manager = $manager;
    }

    function getIterator() {
        $that = $this;

        return new phpMorphy_Util_Iterator_Transform(
            parent::getIterator(),
            function(phpMorphy_Dict_Flexia $flexia) use ($that) {
                return $that->__decorate($flexia);
            }
        );
    }

    function offsetGet($offset) {
        return $this->__decorate(parent::offsetGet($offset));
    }

    function __decorate(phpMorphy_Dict_Flexia $flexia) {
        return new phpMorphy_Dict_Source_NormalizedAncodes_Flexia($this->manager, $flexia);
    }
}