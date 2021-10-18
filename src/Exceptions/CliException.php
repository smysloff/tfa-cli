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

namespace Smysloff\TFA\Exceptions;

/**
 * Class CliException
 *
 * @author Alexander Smyslov <kokoc.smyslov@yandex.ru>
 * @package Smysloff\TFA\Exceptions
 */
class CliException extends TfaException
{
    public const MSG_REQUIRED = "You must pass '%s' as one of the input parameters";
    public const MSG_SINGLETON = "The '%s' argument cannot be used with other command line arguments";
    public const MSG_DUPLICATE = "The same argument has been used twice (in short form '%s' and in long form '%s')";
}
