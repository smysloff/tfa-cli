<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_Dict_Writer_Observer_Standart implements phpMorphy_Dict_Writer_Observer_ObserverInterface {
    protected
        $start_time;

    function __construct($callback) {
        if(!is_callable($callback)) {
            throw new Exception("Invalid callback");
        }

        $this->callback = $callback;
    }

    function onStart() {
        $this->start_time = microtime(true);
    }

    function onEnd() {
        $this->writeMessage(sprintf("Total time = %f", microtime(true) - $this->start_time));
    }

    function onLog($message) {
        $this->writeMessage(sprintf("+%0.2f %s", microtime(true) - $this->start_time, $message));
    }

    protected function writeMessage($msg) {
        call_user_func($this->callback, $msg);
    }
}