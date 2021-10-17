<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_AncodesResolver_ToText implements phpMorphy_AncodesResolver_AncodesResolverInterface {
    protected $gramtab;

    function __construct(phpMorphy_GramTab_GramTabInterface $gramtab) {
        $this->gramtab = $gramtab;
    }

    function resolve($ancodeId) {
        if(!isset($ancodeId)) {
            return null;
        }

        return $this->gramtab->ancodeToString($ancodeId);
    }

    function unresolve($ancode) {
        return $this->gramtab->stringToAncode($ancode);
        //throw new phpMorphy_Exception("Can`t convert grammar info in text into ancode id");
    }
}