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

use Smysloff\TFC\AbstractWriter;

/**
 * Class Writer
 *
 * @author Alexander Smyslov <kokoc.smyslov@yandex.ru>
 * @package Smysloff\TFC\Cli
 */
class Writer extends AbstractWriter
{
    public function print(string $url, ?array $words): int
    {
        echo "URL: $url" . PHP_EOL
            . '----- ----- ----- -----' . PHP_EOL;

        if ($words === null) {
            echo 'Error' . PHP_EOL;
            return 2;
        }

        $total = 0;
        $n = 1;

        foreach ($words as $word => $count) {
            $total += $count;
            printf('%4d. %s [%d]' . PHP_EOL, $n++, $word, $count);
        }

        echo '----- ----- ----- -----' . PHP_EOL
            . "TOTAL: $total" . PHP_EOL;

        return 0;
    }
}
