<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_Semaphore_Empty implements phpMorphy_Semaphore_SemaphoreInterface {
    function lock() { }
    function unlock() { }
    function remove() { }
};