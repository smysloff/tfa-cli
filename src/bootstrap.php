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

$urls = [];
$isCli = PHP_SAPI === 'cli';

$app = new App($isCli);
$isCli
    ? $app->setRootDir(dirname(__DIR__))
    : $app->setUrls($urls);
return $app->run();
