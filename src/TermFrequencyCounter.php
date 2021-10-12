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

use Smysloff\TFC\Exceptions\TfcException;
use Smysloff\TFC\Modules\{CliModule, FileModule, HttpModule, TextModule, PrintModule};
use stdClass;

/**
 * Class TermFrequencyCounter
 *
 * @author Alexander Smyslov <kokoc.smyslov@yandex.ru>
 * @package Smysloff\TFC
 */
final class TermFrequencyCounter
{
    private const PATH = [
        'dir' => 'out',
        'file' => 'output.csv',
    ];

    private const HELP = '--help placeholder message';
    private const VERSION = '--version placeholder message';

    /**
     * @var array
     */
    private array $urls;

    /**
     * @var array
     */
    private array $htmls;

    /**
     * @var array
     */
    private array $words;

    /**
     * @var object
     */
    private object $modules;

    /**
     * TermFrequencyCounter constructor
     */
    public function __construct(private string $root)
    {
        $this->modules = new stdClass();

        $this->modules->cli = new CliModule($this->root, self::PATH);
        $this->modules->file = new FileModule();
        $this->modules->http = new HttpModule();
        $this->modules->text = new TextModule();
        $this->modules->print = new PrintModule();
    }

    /**
     * @return int
     */
    public function run(): int
    {
        $timer = new Timer();

        try {
            $this->cliModule();
            $this->httpModule();
            $this->textModule();
            $this->printModule();
        } catch (TfcException $exception) {
            return $this->printError($exception->getMessage(), 2);
        }

        echo 'total time: ' . $timer->end() . ' sec.' . PHP_EOL;

        return 0;
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

    private function cliModule(): void
    {
        $this->modules->cli->run($this->root);
        if ($this->modules->cli->isHelp()) {
            $this->modules->print->msg(self::HELP);
            exit(0);
        }
        if ($this->modules->cli->isVersion()) {
            $this->modules->print->msg(self::VERSION);
            exit(0);
        }
        $this->urls = $this->modules->cli->isFile()
            ? $this->modules->file->read($this->modules->cli->getInput())
            : [$this->modules->cli->getInput()];
    }

    private function httpModule(): void
    {
        $this->htmls = $this->modules->http->run($this->urls);
    }

    private function textModule(): void
    {
        $this->words = $this->modules->text->run($this->htmls);
    }

    private function printModule(): void
    {
        $this->modules->print->initFileModule($this->modules->file);

        if (!$this->modules->cli->isFile()) {
            $this->modules->cli->isOutput()
                ? $this->modules->print->toFile(
                    $this->urls[0],
                    $this->words[0],
                    $this->modules->cli->getOutput()
                )
                : $this->modules->print->toCli(
                    $this->urls[0],
                    $this->words[0]
                );
        } else {
            $this->modules->print->toDir(
                $this->urls,
                $this->words,
                $this->modules->cli->getOutput()
            );
        }
    }
}
