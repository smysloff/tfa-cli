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

namespace Smysloff\TFC\File;

use Smysloff\TFC\AbstractWriter;

/**
 * Class Writer
 *
 * @author Alexander Smyslov <kokoc.smyslov@yandex.ru>
 * @package Smysloff\TFC\File
 */
class Writer extends AbstractWriter
{
    public function __construct(private $output)
    {
    }

    public function toFile(string $url, array $words): int
    {
        $dir = dirname($this->output);
        if (!is_dir($dir)) {
            mkdir($dir, recursive: true);
        }

        $stream = fopen($this->output, 'w');

        if ($words === null) {
            fwrite($stream, 'error' . PHP_EOL);
            fclose($stream);
            echo "Ошибка. Вывод записан в файл " . $this->output . PHP_EOL;
            return 2;
        }

        $total = 0;
        $n = 1;
        foreach ($words as $word => $count) {
            $total += $count;
            fputcsv($stream, [$n++, $word, $count]);
        }

        fwrite($stream, PHP_EOL);
        fputcsv($stream, ['', 'TOTAL:', $total]);
        fputcsv($stream, ['', 'URL:', $url]);

        fclose($stream);

        echo "Успех. Вывод записан в файл $this->output" . PHP_EOL;

        return 0;
    }

    public function toDir(array $urls, array $words): int
    {
        if (!is_dir($this->output)) {
            mkdir($this->output, recursive: true);
        }

        foreach ($urls as $key => $url) {

            $stream = fopen($this->output . DIRECTORY_SEPARATOR . $url . '.csv', 'w');

            if ($words[$key] === null) {
                fwrite($stream, 'error' . PHP_EOL);
                fclose($stream);
                echo "Ошибка. Вывод записан в файл " . $this->output . DIRECTORY_SEPARATOR . $url . '.csv' . PHP_EOL;
                continue;
            }

            $total = 0;
            $n = 1;
            foreach ($words[$key] as $word => $count) {
                $total += $count;
                fputcsv($stream, [$n++, $word, $count]);
            }

            fwrite($stream, PHP_EOL);
            fputcsv($stream, ['', 'TOTAL:', $total]);
            fputcsv($stream, ['', 'URL:', $url]);

            fclose($stream);

            echo "Успех. Вывод записан в файл " . $this->output . DIRECTORY_SEPARATOR . $url . '.csv' . PHP_EOL;
        }

        return 0;
    }
}
