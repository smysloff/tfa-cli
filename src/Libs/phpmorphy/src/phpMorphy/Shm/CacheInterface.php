<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

interface phpMorphy_Shm_CacheInterface {
    function close();
    function get($filePath);
    function clear();
    function delete($filePath);
    function reload($filePath);
    function reloadIfExists($filePath);
    function free();
}