<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_Aot_GramTab_Reader extends IteratorIterator {
    const TOKENS_SEPARATOR = ' ';
    const INTERNAL_ENCODING = 'utf-8';

    private
        $factory,
        $encoding;

    function __construct($fileName, $encoding, phpMorphy_Aot_GramTab_GramInfoFactory $factory) {
        parent::__construct($this->createIterators($fileName, $encoding));

        $this->factory = $factory;
        $this->encoding = $encoding;
    }

    protected function createIterators($fileName, $encoding) {
        return new phpMorphy_Util_Iterator_Filter(
            new SplFileObject($fileName),
            function($item) {
                // skip comments
                $item = trim($item);
                return strlen($item) && substr($item, 0, 2) != '//';
            }
        );
    }

    function current() {
        $line = trim(parent::current());
        // split by ' '(space) and \t
        $line = preg_replace('~[\x20\x09]+~', ' ', $line);

        $result = explode(self::TOKENS_SEPARATOR, $line);
        $items_count = count($result);

        if($items_count < 3) {
            throw new phpMorphy_Aot_GramTab_Exception("Can`t split [$line] line, too few tokens");
        }
        
        return $this->processTokens($result);
    }

    protected function processTokens($tokens) {
        return $this->factory->create(
            isset($tokens[2]) ? iconv($this->encoding, self::INTERNAL_ENCODING, $tokens[2]) : '',
            isset($tokens[3]) ? iconv($this->encoding, self::INTERNAL_ENCODING, $tokens[3]) : '',
            iconv($this->encoding, self::INTERNAL_ENCODING, $tokens[0])
        );
    }
}