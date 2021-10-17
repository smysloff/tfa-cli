<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

if (!defined('PHPMORPHY_DIR')) {
    define('PHPMORPHY_DIR', __DIR__);
}

require_once(PHPMORPHY_DIR . '/phpMorphy/Loader.php');

spl_autoload_register(array(new phpMorphy_Loader(PHPMORPHY_DIR), 'loadClass'));

if (extension_loaded('morphy')) {
    throw new phpMorphy_Exception("todo: php extension not implemented");
} else {
    class phpMorphy extends phpMorphy_MorphyNative {
    }
}

define('PHPMORPHY_STORAGE_FILE', phpMorphy::STORAGE_FILE);
define('PHPMORPHY_STORAGE_MEM', phpMorphy::STORAGE_MEM);
define('PHPMORPHY_STORAGE_SHM', phpMorphy::STORAGE_SHM);
