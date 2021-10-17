<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_Loader {
    /** @var string */
    protected $root_path;

    /**
     * @param string $rootPath
     */
    function __construct($rootPath) {
        $this->root_path = (string)$rootPath;
    }
    
    /**
     * @param string $class
     * @return string
     */
    static function classNameToFilePath($class) {
        return str_replace('_', DIRECTORY_SEPARATOR, $class) . '.php';
    }

    /**
     * @param string $filePath
     * @return string
     */
    static function filePathToClassName($filePath) {
        return str_replace(DIRECTORY_SEPARATOR, '_', basename($filePath, '.php'));
    }

    /**
     * @param string $class
     * @return bool
     */
    function loadClass($class) {
        if(class_exists($class, false) || interface_exists($class, false)) {
            return false;
        }

        if(substr($class, 0, 9) !== 'phpMorphy') {
            return false;
        }

        $file_path = $this->getRootPath() . DIRECTORY_SEPARATOR .
                     $this->classNameToFilePath($class);

        if(!file_exists($file_path)) {
            return false;
        }

        require($file_path);

        return true;
    }

    /**
     * @return string
     */
    function getRootPath() {
        return $this->root_path;
    }
}