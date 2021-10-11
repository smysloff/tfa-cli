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

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

$bootstrap = 'src' . DIRECTORY_SEPARATOR . 'bootstrap.php';
$autoload = 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
$download = 'https://getcomposer.org/download/';

if (!is_file($bootstrap)) {
    fprintf(
        STDERR,
        "\e[0;31m" . "Error: can't find `" . $bootstrap . '` file.' . "\e[0m" . PHP_EOL
        . 'Check the integrity of the project or try `git pull` command.' . PHP_EOL
    );
    exit(1);
}

if (!is_file($autoload)) {
    fprintf(
        STDERR,
        "\e[0;31m" . "Error: can't find `" . $autoload . '` file.' . "\e[0m" . PHP_EOL
        . 'You must install composer ' . $download
        . " and use `composer install` command in the project's root folder." . PHP_EOL
    );
    exit(1);
}

require_once $autoload;
require_once $bootstrap;
