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
    public const MSG_EMPTY = 'При запуске программы не были переданы аргументы командной строки.'
    . PHP_EOL . "Попробуйте передать '-h' для получения справки по работе программы.";

    public const MSG_DUPLICATES = 'Один и тот же аргумент был передан дважды.'
    . PHP_EOL . "В короткой ('%s') и длинной ('%s') формах.";

    public const MSG_SINGLETONS = "Аргумент '%s' не может использоваться с другими аргументами командной строки.";

    public const MSG_DEPENDENCIES = "Вместе с аргументом '%s' всегда должен использоваться аргумент '%s'.";

    public const MSG_REQUIRED = "Необходимо передать '%s' в качестве одного из входных параметров";
}
