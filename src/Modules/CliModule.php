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

use Smysloff\TFC\Exceptions\CliException;

/**
 * Class CliModule
 *
 * @author Alexander Smyslov <kokoc.smyslov@yandex.ru>
 * @package Smysloff\TFC\Modules
 */
class CliModule
{
    private const OPTIONS = [
        'SHORT' => ''
            . 'h'
            . 'v'
            . 'i:'
            . 'o:',
        'LONG' => [
            'help',
            'version',
            'input:',
            'output:',
        ],
    ];

    private const PATH = [
        'DIR' => 'out',
        'FILE' => 'output.csv',
    ];

    private array $options;

    private bool $isHelp = false;
    private bool $isVersion = false;
    private bool $isFile = false;

    private ?string $input = null;
    private ?string $output = null;

    /**
     * CliModule constructor
     */
    public function __construct()
    {
        $this->options = getopt(self::OPTIONS['SHORT'], self::OPTIONS['LONG']);
    }

    /**
     * @throws CliException
     */
    public function run(string $root): void
    {
        if ($this->checkHelp()) {
            return;
        }
        if ($this->checkVersion()) {
            return;
        }
        $this->checkInput($root);
        $this->checkOutput($root);
    }

    /**
     * @return bool
     */
    public function isHelp(): bool
    {
        return $this->isHelp;
    }

    /**
     * @return bool
     */
    public function isVersion(): bool
    {
        return $this->isVersion;
    }

    /**
     * @return bool
     */
    public function isFile(): bool
    {
        return $this->isFile;
    }

    /**
     * @return string|null
     */
    public function getInput(): ?string
    {
        return $this->input;
    }

    /**
     * @return string|null
     */
    public function getOutput(): ?string
    {
        return $this->output;
    }

    /**
     * @return bool
     * @throws CliException
     */
    private function checkHelp(): bool
    {
        foreach (['h', 'help'] as $key) {
            if (key_exists($key, $this->options)) {
                if ($_SERVER['argc'] > 2 || count($this->options) > 1) {
                    throw new CliException('help must be standalone');
                }
                return $this->isHelp = true;
            }
        }
        return false;
    }

    /**
     * @return bool
     * @throws CliException
     */
    private function checkVersion(): bool
    {
        foreach (['v', 'version'] as $key) {
            if (key_exists($key, $this->options)) {
                if ($_SERVER['argc'] > 2 || count($this->options) > 1) {
                    throw new CliException('version must be standalone');
                }
                return $this->isVersion = true;
            }
        }
        return false;
    }

    /**
     * @param string $root
     * @throws CliException
     */
    private function checkInput(string $root): void
    {
        $input = false;
        foreach (['i', 'input'] as $key) {
            if (key_exists($key, $this->options)) {
                if ($input === true) {
                    throw new CliException('input must be only in one variant 1');
                }
                $this->input = $this->options[$key];
                $input = true;
            }
        }
        if ($input === false) {
            foreach ($_SERVER['argv'] as $key => $arg) {
                if (
                    $key === 0
                    || in_array($_SERVER['argv'][$key - 1], ['-o', '--output'])
                ) {
                    continue;
                }
                if (!str_starts_with($arg, '-')) {
                    if ($input === true) {
                        throw new CliException('input must be only in one variant 2');
                    }
                    $this->input = $arg;
                    $input = true;
                }
            }
        }
        if ($input === false) {
            throw new CliException('input always need to be');
        }
        if (
            is_file($root . DIRECTORY_SEPARATOR . $this->input)
            && is_readable($root . DIRECTORY_SEPARATOR . $this->input)
        ) {
            $this->input = $root . DIRECTORY_SEPARATOR . $this->input;
            $this->isFile = true;
        }
    }

    /**
     * @throws CliException
     */
    private function checkOutput(string $root): void
    {
        $output = false;
        foreach (['o', 'output'] as $key) {
            if (key_exists($key, $this->options)) {
                if ($output === true) {
                    throw new CliException('output must be only in one variant');
                }
                $this->output = $root . DIRECTORY_SEPARATOR . $this->options[$key];
                $output = true;
            }
        }
        if ($output === false) {
            $this->output = $root . DIRECTORY_SEPARATOR . self::PATH['DIR'];
            if ($this->isFile()) {
                $this->output .= DIRECTORY_SEPARATOR . self::PATH['FILE'];
            }
        }
    }
}
