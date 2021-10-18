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

namespace Smysloff\TFA;

use Smysloff\TFA\Exceptions\TfaException;
use Smysloff\TFA\Modules\{CliModule, FileModule, HttpModule, TextModule, PrintModule};
use stdClass;

/**
 * Class TermFrequencyCounter
 *
 * @author Alexander Smyslov <kokoc.smyslov@yandex.ru>
 * @package Smysloff\TFA
 */
final class TermFrequencyAnalyzer
{
    private const USER_AGENT = 'Mozilla/5.0 (compatible; Selby Agency; +https://selby.su)';

    private const PATH = [
        'dir' => 'out',
        'file' => 'output.csv',
    ];

    private const HELP = ''
        . 'Term frequency analyze of web-page(s).' . PHP_EOL
        . PHP_EOL
        . 'Usage' . PHP_EOL
        . '  php tfa.php <input>' . PHP_EOL
        . 'or' . PHP_EOL
        . '  php tfa.php -i <input> [-o <output>]' . PHP_EOL
        . PHP_EOL
        . 'Options' . PHP_EOL
        . '  -i, --input <input>       URL of web-page or file with list of URLs' . PHP_EOL
        . '  -o, --output <output>     file of text-analyze\'s output for single URL or directory for URLs list ' . PHP_EOL
        . '  -v, --version             output version information and exit' . PHP_EOL
        . '  -h, --help                display this help and exit' . PHP_EOL
        . PHP_EOL
        . 'Examples' . PHP_EOL
        . '  php tfa.php example.com               analyze example.com page and display output to CLI' . PHP_EOL
        . '  php tfa.php -i in/urls.txt -o out     analyze all pages in URLs list and display output to separate files in directory ./out';

    private const VERSION = ''
        . 'Term Frequency Analyzer 0.2.0' . PHP_EOL
        . PHP_EOL
        . 'License GPLv3+: GNU GPL version 3 or later <https://gnu.org/licenses/gpl.html>' . PHP_EOL
        . 'This is free software: you are free to change and redistribute it.' . PHP_EOL
        . 'There is NO WARRANTY, to the extent permitted by law.' . PHP_EOL
        . PHP_EOL
        . 'Written by Alexander Smyslov <kokoc.smyslov@yandex.ru>.';

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
     * @throws Exceptions\TextException
     */
    public function __construct(private string $root)
    {
        $this->modules = new stdClass();

        $this->modules->cli = new CliModule($this->root, self::PATH);
        $this->modules->file = new FileModule();
        $this->modules->http = new HttpModule(self::USER_AGENT);
        $this->modules->text = new TextModule($this->root);
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
        } catch (TfaException $exception) {
            return $this->modules->print->error($exception->getMessage(), 2);
        }

        echo 'total time: ' . $timer->end() . ' sec.' . PHP_EOL;

        return 0;
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
