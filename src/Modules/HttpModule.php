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

/**
 * Class HttpModule
 *
 * @author Alexander Smyslov <kokoc.smyslov@yandex.ru>
 * @package Smysloff\TFC\Modules
 */
class HttpModule
{
    private const USER_AGENT = 'Mozilla/5.0 (compatible; Selby Agency; +https://selby.su)';

    private const OPTIONS = [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_AUTOREFERER => true,
        CURLOPT_USERAGENT => self::USER_AGENT,
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_HEADER => false,
    ];

    public function run(array $urls)
    {
        $mh = curl_multi_init();

        $handlers = [];
        foreach ($urls as $key => $url) {
            $handlers[$key] = curl_init($url);
            curl_setopt_array($handlers[$key], self::OPTIONS);
            curl_multi_add_handle($mh, $handlers[$key]);
        }

        do {
            curl_multi_exec($mh, $running);
            curl_multi_select($mh);
        } while ($running);

        $responses = [];
        foreach ($handlers as $key => $handler) {
            $responses[$key] = curl_multi_getcontent($handler) ?: null;
            curl_multi_remove_handle($mh, $handler);
        }
        curl_multi_close($mh);

        return $responses;
    }
}
