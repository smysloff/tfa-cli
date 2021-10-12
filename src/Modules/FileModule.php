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
 * Class FileModule
 *
 * @author Alexander Smyslov <kokoc.smyslov@yandex.ru>
 * @package Smysloff\TFC\Modules
 */
class FileModule
{
    /**
     * @param string $filename
     * @return array
     * @throws FileException
     */
    public function read(string $filename): array
    {
        $urls = [];
        $stream = fopen($filename, 'r');
        if ($stream === false) {
            throw new FileException("Can't open the file " . $filename);
        }
        while (!feof($stream)) {
            $line = fgets($stream);
            if ($line === false) {
                break;
            }
            if (!empty($url = trim($line))) {
                $urls[] = $url;
            }
        }
        fclose($stream);

        return $urls;
    }
}
