<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_Semaphore_Nix implements phpMorphy_Semaphore_SemaphoreInterface {
    const DEFAULT_PERM = 0644;

    private $sem_id = false;

    function __construct($key) {
        if(false === ($this->sem_id = sem_get($key, 1, self::DEFAULT_PERM, true))) {
            throw new phpMorphy_Exception("Can`t get semaphore for '$key' key");
        }
    }

    function lock() {
        if(false === sem_acquire($this->sem_id)) {
            throw new phpMorphy_Exception("Can`t acquire semaphore");
        }
    }

    function unlock() {
        if(false === sem_release($this->sem_id)) {
            throw new phpMorphy_Exception("Can`t release semaphore");
        }
    }

    function remove() {
        sem_remove($this->sem_id);
    }
}