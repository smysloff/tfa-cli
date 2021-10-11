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
use Smysloff\TFC\Modules\{
    CliModule,
    HttpModule,
    TextModule,
    PrintModule
};
use stdClass;

/**
 * Class TermFrequencyCounter
 *
 * @author Alexander Smyslov <kokoc.smyslov@yandex.ru>
 * @package Smysloff\TFC
 */
final class TermFrequencyCounter
{
    /**
     * @var array
     */
    private array $urls;

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

        $this->modules->cli = new CliModule();
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

        echo $timer->end() . PHP_EOL;

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
            ? file($this->modules->cli->getInput())
            : [$this->modules->cli->getInput()];
    }

    private function httpModule(): void
    {
        $this->modules->http->run();
    }

    private function textModule(): void
    {
        $this->modules->text->run();
    }

    private function printModule(): void
    {
        print_r($this->urls);
    }
}
