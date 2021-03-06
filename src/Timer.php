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

namespace Smysloff\TFA;

/**
 * Class Timer
 *
 * @author Alexander Smyslov <kokoc.smyslov@yandex.ru>
 * @package Smysloff\TFA
 */
class Timer
{
    /**
     * @var float
     */
    private float $start;

    /**
     * Timer constructor
     */
    public function __construct()
    {
        $this->start = hrtime(true);
    }

    /**
     * @return float
     */
    public function end(): float
    {
        $end = hrtime(true);
        $delta = $end - $this->start;

        return round($delta / 1e+9, 3); // nanoseconds => seconds
    }
}
