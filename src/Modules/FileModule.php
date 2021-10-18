<?php

/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Smysloff\TFA\Modules;

use Smysloff\TFA\Exceptions\FileException;

/**
 * Class FileModule
 *
 * @author Alexander Smyslov <kokoc.smyslov@yandex.ru>
 * @package Smysloff\TFA\Modules
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
            throw new FileException(
                sprintf(FileException::MSG_NOT_FILE, $filename)
            );
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

    /**
     * @param string $url
     * @param array|null $words
     * @param string $filename
     * @throws FileException
     */
    public function write(string $url, ?array $words, string $filename): void
    {
        $stream = fopen($filename, 'w');
        if ($stream === false) {
            throw new FileException(
                sprintf(FileException::MSG_NOT_FILE, $filename)
            );
        }

        if ($words === null) {
            fputs($stream, 'error');
        } else {
            $n = 1;
            $all = 0;
            foreach ($words as $word => $term) {
                $all += $term['count'];
                fputcsv($stream, [$n++, '['.$word.']', '['.$term['count'].']']);
                foreach ($term['forms'] as $form => $count) {
                    fputcsv($stream, ['', mb_strtolower($form), $count]);
                }
            }
            fputs($stream, PHP_EOL);
            fputcsv($stream, ['', 'all:', $all]);
            fputcsv($stream, ['', 'url:', $url]);
        }

        fclose($stream);
    }
}
