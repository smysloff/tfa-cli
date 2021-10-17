<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_Source_Dba implements phpMorphy_Source_SourceInterface {
    const DEFAULT_HANDLER = 'db3';

    protected $handle;

    function __construct($fileName, $options = null) {
        $this->handle = $this->openFile($fileName, $this->repairOptions($options));
    }

    function close() {
        if(isset($this->handle)) {
            dba_close($this->handle);
            $this->handle = null;
        }
    }

    static function getDefaultHandler() {
        return self::DEFAULT_HANDLER;
    }

    protected function openFile($fileName, $options) {
        if(false === ($new_filename = realpath($fileName))) {
            throw new phpMorphy_Exception("Can`t get realpath for '$fileName' file");
        }

        $lock_mode = $options['lock_mode'];
        $handler = $options['handler'];
        $func = $options['persistent'] ? 'dba_popen' : 'dba_open';

        if(false === ($result = $func($new_filename, "r$lock_mode", $handler))) {
            throw new phpMorphy_Exception("Can`t open '$fileName' file");
        }

        return $result;
    }

    protected function repairOptions($options) {
        $defaults = array(
            'lock_mode' => 'd',
            'handler' => self::getDefaultHandler(),
            'persistent' => false
        );

        return (array)$options + $defaults;
    }

    function getValue($key) {
        return dba_fetch($key, $this->handle);
    }
}