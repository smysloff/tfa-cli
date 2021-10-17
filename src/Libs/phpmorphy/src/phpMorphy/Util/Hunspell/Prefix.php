<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_Util_Hunspell_Prefix extends phpMorphy_Util_Hunspell_AffixAbstract {
	protected function getRegExp($find) {
		return "~^{$find}~iu";
	}

	function generateWord($word) {
		if(!$this->isMatch($word)) {
			return false;
		}

		if($this->remove_len && mb_strlen($word) >= $this->remove_len) {
			$word = mb_substr($word, $this->remove_len);
		}

		return "{$this->append}$word";
	}

	protected function simpleMatch($word) {
		return mb_substr($word, 0, $this->find_len) == $this->find;
	}
}