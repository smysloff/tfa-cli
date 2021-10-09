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

use Smysloff\TFC\Exceptions\CliException;

/**
 * Class Validation
 *
 * @author Alexander Smyslov <kokoc.smyslov@yandex.ru>
 * @package Smysloff\TFC\Cli
 */
class Validation
{
    /**
     * Validation constructor
     *
     * @param array $options
     */
    public function __construct(private array $options)
    {
    }

    /**
     * @throws CliException
     */
    public function empty(): self
    {
        if ($_SERVER['argc'] < 2) {
            throw new CliException(CliException::MSG_EMPTY);
        }

        return $this;
    }

    /**
     * Проверяет, не передан ли один и тот же аргумент как в короткой, так и в длинной форме.
     * Метод работает только если каждый аргумент имеет обе формы записи,
     * и массивы с аргументами передаются в соответствующем порядке.
     *
     * @param array $short_options
     * @param array $long_options
     * @return $this
     * @throws CliException
     */
    public function duplicates(array $short_options, array $long_options): self
    {
        foreach ($short_options as $key => $value) {
            if (
                array_key_exists($value, $this->options)
                && array_key_exists($long_options[$key], $short_options)
            ) {
                throw new CliException(
                    sprintf(CliException::MSG_DUPLICATES, $value, $long_options[$key])
                );
            }
        }

        return $this;
    }

    /**
     * @param array $singletons
     * @return $this
     * @throws CliException
     */
    public function singletons(array $singletons): self
    {
        if (count($this->options) > 1) {
            foreach ($singletons as $option) {
                if (array_key_exists($option, $this->options)) {
                    throw new CliException(
                        sprintf(CliException::MSG_SINGLETONS, $option)
                    );
                }
            }
        }

        return $this;
    }

    /**
     * @param array $dependencies
     * @return $this
     * @throws CliException
     */
    public function dependencies(array $dependencies = []): self
    {
        foreach ($dependencies as $key => $values) {
            if (array_key_exists($key, $this->options)) {
                $isset = false;
                foreach ($values as $value) {
                    if (array_key_exists($value, $this->options)) {
                        $isset = true;
                    }
                }
                if (!$isset) {
                    throw new CliException(
                        sprintf(
                            CliException::MSG_DEPENDENCIES,
                            $key,
                            implode("' или '", $values)
                        )
                    );
                }
            }
        }

        return $this;
    }
}
