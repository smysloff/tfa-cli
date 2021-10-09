<?php

/*
 * This file is part of the Term Frequency Checker.
 *
 * (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Smysloff\TFC\Text;

use DOMDocument;

/**
 * Class Parser
 *
 * @author Alexander Smyslov <kokoc.smyslov@yandex.ru>
 * @package Smysloff\TFC\Text
 */
class Parser
{
    /**
     * cyrillic letters
     */
    private const CYRILLIC = 'йцукенгшщзхъфывапролджэячсмитьбю';

    /**
     * @var string plain html code
     */
    private string $html;

    /**
     * @var string plain text content
     */
    private string $text;

    /**
     * @var array list of words with frequency
     */
    private array $words;

    public function __construct(string $html)
    {
        $this->html = $this->encodingHandler($html);

        $document = new DOMDocument();
        @$document->loadHTML($this->html);
        foreach ($document->getElementsByTagName('*') as $node) {
            if (in_array($node->nodeName, ['head', 'style', 'script'])) {
                $node->parentNode->removeChild($node);
            }
        }

        $this->text = $document->textContent;
        $this->text = mb_strtolower($this->text, 'UTF-8');
        $this->text = str_replace('ё', 'е', $this->text);

        $this->words = str_word_count(
            $this->text,
            1,
            '0..1'
            . self::CYRILLIC
        );
        $this->text = implode(' ', $this->words);
    }

    public function get()
    {
        $this->words = array_count_values($this->words);
        $this->words = array_filter(
            $this->words,
            function($word) {
                return !is_int($word)
                    && mb_substr($word, 0, 1) !== '-'
                    && mb_substr($word, -1, 1) !== '-'
                    && !preg_match('#[^0-9a-z' . self::CYRILLIC . '-]#sui', $word, $matches);
            },
            ARRAY_FILTER_USE_KEY
        );
        arsort($this->words);

        return $this->words;
    }

    private function encodingHandler(string $html): string
    {
        if (!preg_match(
            '#^.*<meta [^>]*charset[^>]*>.*$#miu',
            $html,
            $matches)
        ) {
            $html = preg_replace(
                '#^.*(<head[^>]*>)$#miu',
                '$1<meta charset="utf-8">',
                $html
            );
        }
       return $html;
    }
}
