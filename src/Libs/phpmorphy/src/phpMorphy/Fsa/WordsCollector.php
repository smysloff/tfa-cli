<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_Fsa_WordsCollector {
    protected
        $items = array(),
        $limit;

    function __construct($collectLimit) {
        $this->limit = $collectLimit;
    }

    function collect($word, $annot) {
        if(count($this->items) < $this->limit) {
            $this->items[$word] = $annot;
            return true;
        } else {
            return false;
        }
    }

    function getItems() { return $this->items; }
    function clear() { $this->items = array(); }
    function getCallback() { return array($this, 'collect'); }
};