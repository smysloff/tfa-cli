<?php

/*
 *  This file is part of the Term Frequency Checker.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Smysloff\TFC\Modules;

use Smysloff\TFC\Exceptions\FileException;

/**
 * Class PrintModule
 *
 * @author Alexander Smyslov <kokoc.smyslov@yandex.ru>
 * @package Smysloff\TFC\Modules
 */
class PrintModule
{
    private ?FileModule $file = null;

    /**
     * @param FileModule $fileModule
     * @return PrintModule
     */
    public function initFileModule(FileModule $fileModule): self
    {
        $this->file = $fileModule;
        return $this;
    }

    /**
     * @param string $msg
     * @return PrintModule
     */
    public function msg(string $msg): self
    {
        echo $msg . PHP_EOL;
        return $this;
    }

    /**
     * @param string $url
     * @param array|null $words
     * @return $this
     */
    public function toCli(string $url, ?array $words): self
    {
        if ($words === null) {
            echo 'error' . PHP_EOL;
            return $this;
        }

        $length = strlen((string)(count($words)));
        $n = 1;
        $all = 0;

        foreach ($words as $word => $term) {
            $all += $term['count'];
            printf('%' . $length . 's. [%s] [%s]' . PHP_EOL, $n++, $word, $term['count']);
            foreach ($term['forms'] as $form => $count) {
                printf('%' . $length + 2 . 's %s %s' . PHP_EOL, '-', mb_strtolower($form), $count);
            }
        }

        echo '----- ----- ----- -----' . PHP_EOL
            . '       all: ' . $all . PHP_EOL
            . '       url: ' . $url . PHP_EOL;

        return $this;
    }

    /**
     * @param string $url
     * @param array|null $words
     * @param string $filename
     * @return $this
     * @throws FileException
     */
    public function toFile(string $url, ?array $words, string $filename): self
    {
        if ($words === null) {
            echo 'error' . PHP_EOL;
            return $this;
        }

        $this->createDirIfNotExists(dirname($filename));
        $this->file->write($url, $words, $filename);
        $this->msg('created file ' . $filename);

        return $this;
    }

    /**
     * @param array $urls
     * @param array $words
     * @param string $dirname
     * @return $this
     * @throws FileException
     */
    public function toDir(array $urls, array $words, string $dirname): self
    {
        $this->createDirIfNotExists($dirname);

        foreach ($urls as $key => $url) {
            $filename = $dirname . DIRECTORY_SEPARATOR . $url . '.csv';
            $this->file->write($url, $words[$key], $filename);
            $this->msg('created file ' . $filename);
        }

        return $this;
    }

    /**
     * @param int $code
     * @param string $msg
     * @return int
     */
    public function error(string $msg, int $code = 1): int
    {
        fwrite(STDERR, $msg . PHP_EOL);
        return $code;
    }

    /**
     * @param string $dirname
     */
    private function createDirIfNotExists(string $dirname): void
    {
        if (!is_dir($dirname)) {
            mkdir($dirname, recursive: true);
        }
    }
}
