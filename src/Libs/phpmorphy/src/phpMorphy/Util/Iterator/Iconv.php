<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_Util_Iterator_Iconv extends IteratorIterator {
	private
		$encoding,
		$int_encoding;

	function __construct(Iterator $it, $encoding = null, $internalEncoding = 'UTF-8') {
		parent::__construct($it);

		$this->setEncoding($encoding);
		$this->setInternalEncoding($internalEncoding);
	}

	function ignoreUnknownChars() {
		$this->insertEncModifier('IGNORE');
	}

	function translitUnknownChars() {
		$this->insertEncModifier('IGNORE');
	}

	protected function insertEncModifier($modifier) {
		$enc = $this->getEncodingWithoutModifiers();

		$this->setEncoding("{$enc}//$modifier");
	}

	protected function getEncodingWithoutModifiers() {
		$enc = $this->encoding;

		if(false !== ($pos = strrpos($enc, '//'))) {
			return substr($enc, 0, $pos);
		} else {
			return $enc;
		}
	}

	function setEncoding($encoding) {
		$this->encoding = $encoding;
	}

	function getEncoding() {
		return $this->getEncodingWithoutModifiers();
	}

	function setInternalEncoding($encoding) {
		$this->int_encoding = $encoding;
	}

	function getInternalEncoding() {
		return $this->int_encoding;
	}

	function current() {
        $string = parent::current();
        
		if(isset($this->encoding) && $this->encoding !== $this->int_encoding) {
			$result = iconv($this->encoding, $this->int_encoding, $string);
			//$result = mb_convert_encoding($string, $this->int_encoding, $this->encoding);

			if(!is_string($result)) {
				throw new phpMorphy_Exception(
					"Can`t convert '$string' " . $this->getEncoding() . ' -> ' . $this->getInternalEncoding()
				);
			}

			return $result;
		} else {
			return $string;
		}
	}
}