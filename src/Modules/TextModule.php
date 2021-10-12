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
 * Class TextModule
 *
 * @author Alexander Smyslov <kokoc.smyslov@yandex.ru>
 * @package Smysloff\TFC\Modules
 */
class TextModule
{
    private const DICTIONARY = ''
        . 'ёйцукенгшщзхъфывапролджэячсмитьбю' // cyrillic
        . '';

    private const REGEXP = [
        '#<head[^>]*>(.*)?</head>#sui',
        '#<style[^>]*>(.*)?</style>#sui',
        '#<script[^>]*>(.*)?</script>#sui',
    ];

    /**
     * @param array $htmls
     * @return array
     */
    public function run(array $htmls): array
    {
        $words = [];
        foreach ($htmls as $key => $html) {
            if ($html === null) {
                $words[] = null;
                continue;
            }
            $html = preg_replace(self::REGEXP, '', $html);

            $text = strip_tags($html);
            $text = mb_strtolower($text);
            $text = str_replace('ё', 'е', $text);

            $words[$key] = str_word_count($text, 1, self::DICTIONARY);
            $words[$key] = array_count_values($words[$key]);
            $words[$key] = $this->filter($words[$key]);
            arsort($words[$key]);
        }

        return $words;
    }

    /**
     * @param array $words
     * @return array
     */
    private function filter(array $words): array
    {
        $regexp = '#[^-a-z0-9' . self::DICTIONARY .']#sui';

        $filtered = [];
        foreach ($words as $word => $count) {
            $word = (string)$word;
            if (
                str_starts_with($word,'-')
                || str_ends_with($word,'-')
                || preg_match($regexp, $word) === false
            ) {
                continue;
            }
            $filtered[$word] = $count;
        }

        return $filtered;
    }
}
