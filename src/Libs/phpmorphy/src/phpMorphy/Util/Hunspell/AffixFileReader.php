<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_Util_Hunspell_AffixFileReader extends IteratorIterator {
	function __construct($fileName, $defaultEncoding) {
		parent::__construct($this->createIterators($this->createIterators($fileName)));

		$this->setEncoding($defaultEncoding);
	}

	function setEncoding($enc) {
		$this->getInnerIterator()->setEncoding($enc);
	}

	protected function createIterators($fileName) {
		return new phpMorphy_Util_Iterator_Iconv(
			new phpMorphy_Util_Iterator_Filter(
				new SplFileObject($fileName),
                function($item) {
                    return strlen($item) > 0;
                }
			)
		);
	}
    
	function current() {
		return explode(
			' ',
			preg_replace('~\s{2,}~', ' ', trim(parent::current()))
		);
	}
}