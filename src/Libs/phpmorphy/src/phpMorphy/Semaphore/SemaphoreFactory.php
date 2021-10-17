<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

abstract class phpMorphy_Semaphore_SemaphoreFactory {
    /**
     * @static
     * @param string $key
     * @param bool $createEmpty
     * @return phpMorphy_Semaphore_SemaphoreInterface
     */
    static function create($key, $createEmpty = false) {
        if(!$createEmpty) {
            if (0 == strcasecmp($GLOBALS['__phpmorphy_substr'](PHP_OS, 0, 3), 'WIN')) {
                return new phpMorphy_Semaphore_Win($key);
            } else {
                return new phpMorphy_Semaphore_Nix($key);
            }
        } else {
            return new phpMorphy_Semaphore_Empty($key);
        }
    }
};