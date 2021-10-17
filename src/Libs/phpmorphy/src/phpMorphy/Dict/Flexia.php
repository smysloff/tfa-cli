<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_Dict_Flexia {
    protected
        $prefix,
        $suffix,
        $ancode_id;

    function __construct($prefix, $suffix, $ancodeId) {
        //phpMorphy_Dict_Ancode::checkAncodeId($ancodeId, "Invalid ancode specified for flexia");

        $this->setPrefix($prefix);
        $this->setSuffix($suffix);
        $this->setAncodeId($ancodeId);
    }

    function setPrefix($prefix) { $this->prefix = (string)$prefix; }
    function setSuffix($suffix) { $this->suffix = (string)$suffix; }
    function setAncodeId($id) { $this->ancode_id = $id; }

    function getPrefix() { return $this->prefix; }
    function getSuffix() { return $this->suffix; }
    function getAncodeId() { return $this->ancode_id; }

    function __toString() {
        return phpMorphy_Dict_ModelsFormatter::create()->formatFlexia($this);
    }
}