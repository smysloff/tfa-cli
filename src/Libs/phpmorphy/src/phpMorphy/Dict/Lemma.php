<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_Dict_Lemma {
    protected
        $id,
        $base,
        $flexia_id,
        $accent_id,
        $prefix_id,
        $ancode_id;

    function __construct($base, $flexiaId, $accentId) {
        $this->base = (string)$base;
        $this->flexia_id = (int)$flexiaId;
        $this->accent_id = (int)$accentId;

        if($this->flexia_id < 0) {
            throw new Exception("flexia_id must be positive int");
        }

        if($this->accent_id < 0) {
            throw new Exception("accent_id must be positive int");
        }
    }

    function setId($id) {
        $this->id = $id;
    }

    function getId() {
        return $this->id;
    }

    function hasId() {
        return null !== $this->getId();
    }

    function setPrefixId($prefixId) {
        if(is_null($prefixId)) {
            throw new phpMorphy_Exception("NULL prefix_id specified");
        }

        $this->prefix_id = (int)$prefixId;

        if($this->prefix_id < 0) {
            throw new phpMorphy_Exception("prefix_id must be positive int");
        }
    }

    function setAncodeId($ancodeId) {
        if(is_null($ancodeId)) {
            throw new phpMorphy_Exception("NULL id specified");
        }

        $this->ancode_id = $ancodeId;
    }

    function getBase() { return $this->base; }
    function getFlexiaId() { return $this->flexia_id; }
    function getAccentId() { return $this->accent_id; }
    function getPrefixId() { return $this->prefix_id; }
    function getAncodeId() { return $this->ancode_id; }

    function hasPrefixId() { return isset($this->prefix_id); }
    function hasAncodeId() { return isset($this->ancode_id); }

    function __toString() {
        return phpMorphy_Dict_ModelsFormatter::create()->formatLemma($this);
    }
}