<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

abstract class phpMorphy_Dict_Writer_WriterAbstract implements phpMorphy_Dict_Writer_WriterInterface {
    private $observer;

    function __construct() {
        $this->setObserver(new phpMorphy_Dict_Writer_Observer_Empty());
    }

    function setObserver(phpMorphy_Dict_Writer_Observer_ObserverInterface $observer) {
        $this->observer = $observer;
    }

    function hasObserver() {
        return isset($this->observer);
    }

    function getObserver() {
        return $this->observer;
    }

    protected function log($message) {
        if($this->hasObserver()) {
            $this->getObserver()->onLog($message);
        }
    }
}