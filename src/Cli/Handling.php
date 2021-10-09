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

namespace Smysloff\TFC\Cli;

/**
 * Class Handling
 *
 * @author Alexander Smyslov <kokoc.smyslov@yandex.ru>
 * @package Smysloff\TFC\Cli
 */
class Handling
{
    public function __construct(private array $options)
    {
    }

    /**
     * @param array $options
     * @return bool
     */
    public function singleton(array $options): bool
    {
        foreach ($options as $option) {
            if (array_key_exists($option, $this->options)) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param string $filename
     * @param string $dirname
     * @return bool
     */
    public function isFile(string $filename, string $dirname): bool
    {
        $file = $dirname . DIRECTORY_SEPARATOR . $filename;

        return is_file($file) && is_readable($file);
    }

    /**
     * @param $param
     * @param $dirname
     * @param $isFile
     * @return string
     */
    public function input($param, $dirname, $isFile): string
    {
        return $isFile
            ? $dirname . DIRECTORY_SEPARATOR . $param
            : $param;
    }

    /**
     * @param $param
     * @param $dirname
     * @return string
     */
    public function output($param, $dirname): string
    {
        return $dirname . DIRECTORY_SEPARATOR . $param;
    }
}
