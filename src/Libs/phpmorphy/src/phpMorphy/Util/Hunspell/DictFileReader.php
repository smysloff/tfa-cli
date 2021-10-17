<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_Util_Hunspell_DictFileReader extends IteratorIterator {
	function __construct($fileName, $encoding) {
		parent::__construct($this->createIterators($fileName, $encoding));
	}

	protected function createIterators($fileName, $encoding) {
		return new phpMorphy_Util_Iterator_Iconv(
			new phpMorphy_Util_Iterator_Filter(
                new SplFileObject($fileName),
                function($item) {
                    return strlen($item) > 0;
                }
            ),
			$encoding
		);
	}

	function current() {
		$line = trim(parent::current());

		$word = '';
		$flags = '';
		$morph = '';

		if(false !== ($pos = mb_strpos($line, "\t"))) {
			$morph = trim(mb_substr($line, $pos + 1));
			$line = rtrim(mb_substr($line, 0, $pos));
		}

		if(false !== ($pos = mb_strpos($line, '/'))) {
			$word = rtrim(mb_substr($line, 0, $pos));
			$flags = ltrim(mb_substr($line, $pos + 1));
		} else {
			$word = $line;
		}

		return array(
			'word' => $word,
			'flags' => $this->parseFlags($flags),
			'morph' => $morph
		);
	}

	protected function parseFlags($flags) {
		// TODO: May be long(two chars?) or numeric format(aka compressed)
		// But i support only basic syntax now
		return strlen($flags) ? str_split($flags) : array();
	}
}