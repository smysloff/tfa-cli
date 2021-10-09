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

use Smysloff\TFC\Cli\Writer as CliWritter;
use Smysloff\TFC\Exceptions\CliException;

/**
 * Class Parser
 *
 * @author Alexander Smyslov <kokoc.smyslov@yandex.ru>
 * @package Smysloff\TFC\Cli
 */
class Parser
{
    public CliWritter $writer;

    private array $options;
    private array $short_options;
    private array $long_options;

    private ?string $input = null;
    private ?string $output = null;

    /**
     * @var bool Whether the user asked to show the help information?
     */
    private bool $isHelp = false;

    /**
     * @var bool User requested version info?
     */
    private bool $isVersion = false;

    /**
     * @var bool Whether the input argument is a file?
     */
    private bool $isFile = false;

    /**
     * Parser constructor
     *
     * @param string $short_options
     * @param array $long_options
     */
    public function __construct(
        string $short_options,
        array $long_options
    ) {
        $this->options = getopt($short_options, $long_options);
        $this->short_options = str_split(str_replace(':', '', $short_options));
        foreach ($long_options as $option) {
            $this->long_options[] = str_replace(':', '', $option);
        }
    }

    /**
     * @return string
     */
    public function getInput()
    {
        return $this->input;
    }

    /**
     * @return string
     */
    public function getOutput()
    {
        return $this->output;
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
     * @param array $singletons
     * @param array $dependencies
     * @throws CliException
     */
    public function validation(
        array $singletons = [],
        array $dependencies = []
    ): void {
        (new Validation($this->options))
            ->empty()
            ->duplicates($this->short_options, $this->long_options)
            ->singletons($singletons)
            ->dependencies($dependencies);
    }

    /**
     * @param string $rootDir
     * @param array $default
     * @throws CliException
     */
    public function handling(string $rootDir, array $default): void
    {
        $handling = new Handling($this->options);

        // Case when only one argument is passed
        if ($_SERVER['argc'] === 2) {
            if ($handling->singleton(['h', 'help'])) {
                $this->isHelp = true;
                return;
            }
            if ($handling->singleton(['v', 'version'])) {
                $this->isVersion = true;
                return;
            }
            $param = $_SERVER['argv'][1];
            $this->input = ($this->isFile = $handling->isFile($param, $rootDir))
                ? $rootDir . DIRECTORY_SEPARATOR . $param
                : $param;
            return;
        }

        // Case when multiple arguments are passed

        // - check if input is passed
        if (
            !isset($this->options['i'])
            && !isset($this->options['input'])
        ) {
            throw new CliException(
                sprintf(
                    CliException::MSG_REQUIRED,
                    implode("' или '", ['i', 'input'])
                )
            );
        }

        // - get input
        $param = $this->options['i'] ?? $this->options['inputs'];
        $this->isFile = $handling->isFile($param, $rootDir);
        $this->input = $handling->input($param, $rootDir, $this->isFile);

        // - get output
        $default = $this->isFile ? $default['dir'] : $default['file'];
        $param = $this->options['o'] ?? ($this->options['output'] ?? $default);
        $this->output = $handling->output($param, $rootDir);
    }

    /**
     * @return string[]
     */
    public function getUrls(): array
    {
        if ($this->isFile) {
            return file(
                $this->input,
                FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES
            );
        }
        return [$this->input ?? null];
    }
}
