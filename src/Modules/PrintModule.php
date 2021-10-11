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

/**
 * Class PrintModule
 *
 * @author Alexander Smyslov <kokoc.smyslov@yandex.ru>
 * @package Smysloff\TFC\Modules
 */
class PrintModule
{
    /**
     * @param string $msg
     */
    public function msg(string $msg): void
    {
        echo $msg . PHP_EOL;
    }
}
