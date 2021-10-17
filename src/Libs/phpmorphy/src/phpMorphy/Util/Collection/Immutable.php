<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */


class phpMorphy_Util_Collection_Immutable extends phpMorphy_Util_Collection_Decorator {
    function import($values) {
        throw new phpMorphy_Exception("Collection is immutable");
    }

    function append($value) {
        throw new phpMorphy_Exception("Collection is immutable");
    }

    function clear() {
        throw new phpMorphy_Exception("Collection is immutable");
    }

    function offsetSet($offset, $value) {
        throw new phpMorphy_Exception("Collection is immutable");
    }

    function offsetUnset($offset) {
        throw new phpMorphy_Exception("Collection is immutable");
    }
}