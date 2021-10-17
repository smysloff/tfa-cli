<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_Semaphore_Win implements phpMorphy_Semaphore_SemaphoreInterface {
    const DIR_NAME = 'phpmorphy_semaphore';
    const USLEEP_TIME = 100000; // 0.1s
    const MAX_SLEEP_TIME = 5000000; // 5sec

    protected $dir_path;

    function __construct($key) {
        $this->dir_path = $this->getTempDir() . DIRECTORY_SEPARATOR . self::DIR_NAME . "_$key";

        register_shutdown_function(array($this, 'unlock'));
    }

    protected function getTempDir() {
        if(false === ($result = getenv('TEMP'))) {
            if(false === ($result = getenv('TMP'))) {
                throw new phpMorphy_Exception("Can`t get temporary directory");
            }
        }

        return $result;
    }

    function lock() {
        for($i = 0; $i < self::MAX_SLEEP_TIME; $i += self::USLEEP_TIME) {
            if(!file_exists($this->dir_path)) {
                if(false !== @mkdir($this->dir_path, 0644)) {
                    return true;
                }
            }

            usleep(self::USLEEP_TIME);
        }

        throw new phpMorphy_Exception("Can`t acquire semaphore");
    }

    function unlock() {
        @rmdir($this->dir_path);
    }

    function remove() {
    }
}