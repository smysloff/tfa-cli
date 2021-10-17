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

namespace Smysloff\TFA\Modules;

use Smysloff\TFA\Exceptions\CliException;

/**
 * Class CliModule
 *
 * @author Alexander Smyslov <kokoc.smyslov@yandex.ru>
 * @package Smysloff\TFA\Modules
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

    private array $options;

    private bool $isHelp = false;
    private bool $isVersion = false;
    private bool $isFile = false;
    private bool $isInput = false;
    private bool $isOutput = false;

    private ?string $input = null;
    private ?string $output = null;

    /**
     * CliModule constructor
     */
    public function __construct(
        private string $root,
        private array $path
    )
    {
        $this->options = getopt(self::OPTIONS['SHORT'], self::OPTIONS['LONG']);
    }

    /**
     * @throws CliException
     */
    public function run(): void
    {
        if ($this->checkHelp()) {
            return;
        }
        if ($this->checkVersion()) {
            return;
        }
        $this->checkInput($this->root);
        $this->checkOutput($this->root);
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
     * @return bool
     */
    public function isInput()
    {
        return $this->isInput;
    }

    /**
     * @return bool
     */
    public function isOutput()
    {
        return $this->isOutput;
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
        if (
            $_SERVER['argc'] === 2
            && !str_starts_with($_SERVER['argv'][1], '-')
        ) {
            $this->input = $_SERVER['argv'][1];
            $this->isInput = true;
        } else {
            foreach (['i', 'input'] as $key) {
                if (key_exists($key, $this->options)) {
                    if ($this->isInput === true) {
                        throw new CliException('input must be only in one variant 1');
                    }
                    $this->input = $this->options[$key];
                    $this->isInput = true;
                }
            }
        }

        if ($this->isInput === false) {
            throw new CliException('input always need to be');
        }
        $this->isInput = true;

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
        foreach (['o', 'output'] as $key) {
            if (key_exists($key, $this->options)) {
                if ($this->isOutput === true) {
                    throw new CliException('output must be only in one variant');
                }
                $this->output = $root . DIRECTORY_SEPARATOR . $this->options[$key];
                $this->isOutput = true;
            }
        }
        if ($this->isOutput === false) {
            $this->output = $root . DIRECTORY_SEPARATOR . $this->path['dir'];
            if (!$this->isFile()) {
                $this->output .= DIRECTORY_SEPARATOR . $this->path['file'];
            }
        }
    }
}
