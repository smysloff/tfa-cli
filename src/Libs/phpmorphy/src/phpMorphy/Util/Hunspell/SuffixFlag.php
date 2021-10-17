<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_Util_Hunspell_SuffixFlag extends phpMorphy_Util_Hunspell_AffixFlagAbstract {
	protected function createAffix($find, $remove, $append, $morph) {
		return new phpMorphy_Util_Hunspell_Suffix(
			$find,
			$remove,
			$append,
			$morph
		);
	}

	function isSuffix() { return true; }
}