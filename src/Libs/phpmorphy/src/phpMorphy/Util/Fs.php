<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_Util_Fs {
    /**
     * @static
     * @param string $rootDir
     * @param string $matchRegExp
     * @param Closure|string $fn
     * @param bool $isRecursive
     * @return int
     */
    static function applyToEachFile($rootDir, $matchRegExp, $fn, $isRecursive = true) {
        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($rootDir));
        $count = 0;

        foreach($iterator as $item) {
            if($iterator->isDot()) continue;
            $path = $item->getPathName();

            if(preg_match($matchRegExp, $path)) {
                ++$count;

                if(false === $fn($path)) {
                    break;
                }
            }
        }

        return $count;
    }

    /**
     * Delete empty directories (directories which contains only directories) starting from $dir
     * @static
     * @param string $dir
     * @param Closure|string|null $log
     * @return void
     */
    static function deleteEmptyDirectories($dir, $log = null) {
        $iterator = new DirectoryIterator($dir);
        $files_in_dir = 0;

        foreach($iterator as $node) {
            if($iterator->isDot()) continue;
            $pathname = $iterator->getPathName();
            $filename = $iterator->getFilename();

            if($iterator->isDir()) {
                 $files_in_dir += self::deleteEmptyDirectories(
                     $iterator->getPathName(),
                     $log
                 );
            } else {
                $files_in_dir++;
            }
        }

        if($files_in_dir == 0) {
            if(null !== $log) {
                $log("Remove empty dir '$dir'");
            }

            rmdir($dir);
        }

        return $files_in_dir;
    }
}