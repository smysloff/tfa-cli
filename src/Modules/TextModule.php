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

use phpMorphy;
use phpMorphy_Exception;
use phpMorphy_FilesBundle;
use Smysloff\TFA\Exceptions\TextException;
use stdClass;

/**
 * Class TextModule
 *
 * @author Alexander Smyslov <kokoc.smyslov@yandex.ru>
 * @package Smysloff\TFA\Modules
 */
class TextModule
{
    private const DICTIONARY = ''
    . 'ёйцукенгшщзхъфывапролджэячсмитьбю' // cyrillic
    . 'ЁЙЦУКЕНГШЩЗХЪФЫВАПРОЛДЖЭЯЧСМИТЬБЮ' // CYRILLIC
    . '';

    private const REGEXP = [
        '#<head[^>]*>(.*)?</head>#sui',
        '#<style[^>]*>(.*)?</style>#sui',
        '#<script[^>]*>(.*)?</script>#sui',
    ];

    /**
     * @var stdClass
     */
    private stdClass $morphy;

    /**
     * TextModule constructor
     * @param string $root
     * @throws TextException
     */
    public function __construct(private string $root)
    {
        // first we include phpmorphy library
        require_once $this->root . DIRECTORY_SEPARATOR
            . 'src' . DIRECTORY_SEPARATOR
            . 'Libs' . DIRECTORY_SEPARATOR
            . 'phpmorphy' . DIRECTORY_SEPARATOR
            . 'src' . DIRECTORY_SEPARATOR
            . 'common.php';

        // set some options
        $opts = [
            // PHPMORPHY_STORAGE_MEM - load dict to memory each time when phpMorphy intialized, this useful when shmop ext. not activated. Speed same as for PHPMORPHY_STORAGE_SHM type
            'storage' => PHPMORPHY_STORAGE_FILE,
            // Extend graminfo for getAllFormsWithGramInfo method call
            'with_gramtab' => true,
            // Enable prediction by suffix
            'predict_by_suffix' => true,
            // Enable prediction by prefix
            'predict_by_db' => true
        ];

        // Path to directory where dictionaries located
        $dir = $this->root . DIRECTORY_SEPARATOR
            . 'src' . DIRECTORY_SEPARATOR
            . 'Libs' . DIRECTORY_SEPARATOR
            . 'phpmorphy' . DIRECTORY_SEPARATOR
            . 'dicts' . DIRECTORY_SEPARATOR;

        // Create descriptor for dictionary located in $dir directory with russian language
        $dict_bundle_rus = new phpMorphy_FilesBundle($dir, 'rus');
        $dict_bundle_eng = new phpMorphy_FilesBundle($dir, 'eng');

        // Create phpMorphy instance
        try {
            $this->morphy = new stdClass();
            $this->morphy->rus = new phpMorphy($dict_bundle_rus, $opts);
            $this->morphy->eng = new phpMorphy($dict_bundle_eng, $opts);
        } catch (phpMorphy_Exception $e) {
            throw new TextException(
                sprintf(TextException::MSG_PHPMORPHY, $e->getMessage())
            );
        }
    }

    /**
     * @param array $htmls
     * @return array
     */
    public function run(array $htmls): array
    {
        $result = [];
        $words = [];
        $terms = [];

        foreach ($htmls as $key => $html) {
            if ($html === null) {
                $result[] = null;
                continue;
            }
            $html = preg_replace(self::REGEXP, '', $html);

            $text = strip_tags($html);
            $text = mb_strtoupper($text);
            $text = str_replace('Ё', 'Е', $text);

            $words[$key] = str_word_count($text, 1, self::DICTIONARY);
            $words[$key] = array_count_values($words[$key]);
            $words[$key] = $this->filter($words[$key]);

            foreach ($words[$key] as $word => $count) {
                $rus = $this->morphy->rus->getBaseForm($word);
                if ($rus !== false) {
                    $term = $rus[0];
                }

                if (!isset($term)) {
                    $eng = $this->morphy->eng->getBaseForm($word);
                    if ($eng !== false) {
                        $term = $eng[0];
                    }
                }

                if (!isset($term)) {
                    $term = $word;
                }

                if (!isset($terms[$term])) {
                    $terms[$term] = [];
                }

                $terms[$term]['count'] = isset($terms[$term]['count']) ? $terms[$term]['count'] + $count : $count;
                $terms[$term]['forms'][$word] = $count;

                unset($term);
            }

            uasort($terms, fn($a, $b) => $b['count'] <=> $a['count']);

            foreach ($terms as &$value) {
                uasort($value['forms'], fn($a, $b) => $b <=> $a);
            }
            reset($terms);

            $result[] = $terms;
        }

        return $result;
    }

    /**
     * @param array $words
     * @return array
     */
    private function filter(array $words): array
    {
        $regexp = '#[^-a-zA-Z0-9' . self::DICTIONARY . ']#sui';

        $filtered = [];
        foreach ($words as $word => $count) {
            $word = (string)$word;
            if (
                str_starts_with($word, '-')
                || str_ends_with($word, '-')
                || preg_match($regexp, $word) === false
            ) {
                continue;
            }
            $filtered[$word] = $count;
        }

        return $filtered;
    }
}
