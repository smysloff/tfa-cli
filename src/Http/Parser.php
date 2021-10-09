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

namespace Smysloff\TFC\Http;

use CurlHandle;
use CurlMultiHandle;

/**
 * Class Parser
 *
 * @author Alexander Smyslov <kokoc.smyslov@yandex.ru>
 * @package Smysloff\TFC\Http
 */
class Parser
{
    private const USER_AGENT = 'Mozilla/5.0 (compatible; Selby Agency; +https://selby.su)';

    private const CURLOPT = [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_AUTOREFERER => true,
        CURLOPT_USERAGENT => self::USER_AGENT,
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_HEADER => false,
    ];

    private CurlMultiHandle $multiHandler;
    private array $handlers;

    /**
     * Parser constructor
     *
     * @param array $urls
     */
    public function __construct(array $urls)
    {
        $this->multiHandler = curl_multi_init();

        foreach ($urls as $key => $url) {
            $this->handlers[$key] = curl_init($url);
            curl_setopt_array($this->handlers[$key], self::CURLOPT);
            curl_multi_add_handle($this->multiHandler, $this->handlers[$key]);
        }
    }

    public function get(): array
    {
        do {
            curl_multi_exec($this->multiHandler, $running);
            curl_multi_select($this->multiHandler);
        } while ($running);

        $responses = [];
        foreach ($this->handlers as $key => $handler) {
            $responses[$key] = curl_multi_getcontent($handler) ?: null;
            curl_multi_remove_handle($this->multiHandler, $handler);
        }
        curl_multi_close($this->multiHandler);

        return $responses;
    }
}
