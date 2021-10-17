<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_AncodesResolver_ToDialingAncodes implements phpMorphy_AncodesResolver_AncodesResolverInterface {
    protected
        $ancodes_map,
        $reverse_map;

    function __construct(phpMorphy_Storage_StorageInterface $ancodesMap) {
        if(false === ($this->ancodes_map = unserialize($ancodesMap->read(0, $ancodesMap->getFileSize())))) {
            throw new phpMorphy_Exception("Can`t open phpMorphy => Dialing ancodes map");
        }

        $this->reverse_map = array_flip($this->ancodes_map);
    }

    function unresolve($ancode) {
        if(!isset($ancode)) {
            return null;
        }

        if(!isset($this->reverse_map[$ancode])) {
            throw new phpMorphy_Exception("Unknwon ancode found '$ancode'");
        }

        return $this->reverse_map[$ancode];
    }

    function resolve($ancodeId) {
        if(!isset($ancodeId)) {
            return null;
        }

        if(!isset($this->ancodes_map[$ancodeId])) {
            throw new phpMorphy_Exception("Unknwon ancode id found '$ancodeId'");
        }

        return $this->ancodes_map[$ancodeId];
    }
}