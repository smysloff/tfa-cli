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

namespace Smysloff\TFC;

use Smysloff\TFC\Cli\Parser as CliParser;
use Smysloff\TFC\Http\Parser as HttpParser;
use Smysloff\TFC\Text\Parser as TextParser;
use Smysloff\TFC\Cli\Writer as CliWriter;
use Smysloff\TFC\File\Writer as FileWriter;
use Smysloff\TFC\Exceptions\CliException;
use Smysloff\TFC\Exceptions\HttpException;

/**
 * Class TermFrequencyCounter
 *
 * @author Alexander Smyslov <kokoc.smyslov@yandex.ru>
 * @package Smysloff\TFC
 */
final class TermFrequencyCounter
{
    private const CLI_OPTIONS = [
        'short' => 'hvi:o:',
        'long' => [
            'help',
            'version',
            'input:',
            'output:',
        ],
        'singletons' => [
            'h',
            'help',
            'v',
            'version',
        ],
        'dependencies' => [
            'o' => ['i', 'input'],
            'output' => ['i', 'input'],
        ],
    ];

    private const DEFAULT_CLI_PATH = [
        'file' => 'out' . DIRECTORY_SEPARATOR . 'out.csv',
        'dir' => 'out',
    ];

    /**
     * @var array List of web pages where needs to count the terms frequency
     */
    private array $urls;

    /**
     * @var array List of html-content from web pages
     */
    private array $html;

    /**
     * @var array
     */
    private array $words;

    /**
     * @var string
     */
    private string $rootDir;

    /**
     * @var CliParser
     */
    private CliParser $cli;

    /**
     * TermFrequencyCounter constructor
     */
    public function __construct(private bool $isCli = false)
    {
        if ($this->isCli) {
            $this->cli = new CliParser(self::CLI_OPTIONS['short'], self::CLI_OPTIONS['long']);
        }
    }

    /**
     * @param string $rootDir
     * @return $this
     */
    public function setRootDir(string $rootDir): self
    {
        $this->rootDir = $rootDir;
        return $this;
    }

    /**
     * @param array $urls
     * @return $this
     */
    public function setUrls(array $urls): self
    {
        $this->urls = $urls;
        return $this;
    }

    /**
     * @return int
     */
    public function run(): int
    {
        if ($this->isCli) {
            try {
                $this->cliModule();

                if ($this->cli->isHelp()) {
                    echo 'help' . PHP_EOL;
                    return 0;
                }

                if ($this->cli->isVersion()) {
                    echo 'version' . PHP_EOL;
                    return 0;
                }
            } catch (CliException $exception) {
                return $this->printError($exception->getMessage());
            }
        }

        try {
            $this->httpModule();
        } catch (HttpException $exception) {
            return $this->printError($exception->getMessage());
        }

        $this->textModule();

        if ($code = $this->printResult()) {
            return $code;
        }

        return 0;
    }

    /**
     * @throws CliException
     */
    private function cliModule(): void
    {
        $this->cli->validation(
            self::CLI_OPTIONS['singletons'],
            self::CLI_OPTIONS['dependencies']
        );

        $this->cli->handling(
            $this->rootDir,
            self::DEFAULT_CLI_PATH
        );

        $this->urls = $this->cli->getUrls();
    }

    /**
     * @throws HttpException
     */
    private function httpModule(): void
    {
        $this->html = (new HttpParser($this->urls))->get();
    }

    private function textModule(): void
    {
        foreach ($this->html as $html) {
            if ($html === null) {
                $this->words[] = null;
                continue;
            }
            $this->words[] = (new TextParser($html))->get();
        }
    }


    private function printResult(): int
    {
        if ($this->isCli) {

            if (!$this->cli->isFile() && !$this->cli->getOutput()) {
                return (new CliWriter())->print($this->urls[0], $this->words[0]);
            }

            if (!$this->cli->isFile() && $this->cli->getOutput()) {
                return (new FileWriter($this->cli->getOutput() ?? self::DEFAULT_CLI_PATH['file']))
                    ->toFile($this->urls[0], $this->words[0]);
            }

            return (new FileWriter($this->cli->getOutput() ?? self::DEFAULT_CLI_PATH['dir']))
                ->toDir($this->urls, $this->words);
        }

        return $this->printError("Работа TFC в качестве встраиваемой библиотеки еще не поддерживается", 2);
    }

    /**
     * @param int $code
     * @param string $msg
     * @return int
     */
    private function printError(string $msg, int $code = 1): int
    {
        fwrite(STDERR, $msg . PHP_EOL);
        return $code;
    }
}
