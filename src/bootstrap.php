<?php

/*
 *  This file is part of the Term Frequency Checker.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

use Smysloff\TFC\TermFrequencyCounter as App;

$app = new App(dirname(__DIR__));
return $app->run();
