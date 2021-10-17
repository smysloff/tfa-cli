<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

abstract class phpMorphy_Util_Hunspell_AffixAbstract {
	protected
		$remove_len,
		$remove,
		$append,
		$find,
		$find_len,
		$morph,
		$reg,
		$is_simple,
		$is_empty
		;

	function __construct($find, $remove, $append, $morph = null) {
		$this->remove_len = mb_strlen((string)$remove);
		$this->remove = $remove;
		$this->append = $append;
		$this->morph = $morph;
		$this->find = $find;
		$this->find_len = mb_strlen($find);
		$this->is_simple = $this->isSimple($find);
		$this->is_empty = $this->isEmpty($find);

		$this->reg = $this->getRegExp($find);
	}

	function getRemoveLength() { return $this->remove_len; }
	function isMorphDescription() { return isset($this->morph); }
	function getMorphDescription() { return $this->morph; }

	function isMatch($word) {
		if($this->is_empty) {
			return true;
		}

		if($this->is_simple) {
			return $this->simpleMatch($word);
		} else {
			//return false;
			return preg_match($this->reg, $word) > 0;
			//return mb_ereg_match($this->reg, $word);
		}
	}

	protected function isSimple($find) {
		return strpos($find, '[') === false && strpos($find, '.') === false;
	}

	protected function isEmpty($find) {
		return $find === '.';
	}

	abstract function generateWord($word);

	abstract protected function simpleMatch($word);
	abstract protected function getRegExp($find);
}