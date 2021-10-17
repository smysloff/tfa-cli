<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

abstract class phpMorphy_Util_Hunspell_AffixFlagAbstract {
	protected
		$name,
		$cross_product,
		$affixes = array();

	protected function __construct($name, $cross) {
		$this->name = $name;
		$this->cross_product = $cross;
	}

	static function create($type, $name, $cross) {
		$affix_class = $type == 'SFX' ? 'phpMorphy_Util_Hunspell_SuffixFlag' : 'phpMorphy_Util_Hunspell_PrefixFlag';

		return new $affix_class($name, $cross);
	}

	function getName() {
		return $this->name;
	}

	function isCrossProduct() {
		return $this->cross_product;
	}

	function generateWords($word, &$words, $wordMorph = null, &$morphs = null) {
		$maxRemoveLength = 0;

		foreach($this->affixes as $affix) {
			if(false !== ($new_word = $affix->generateWord($word))) {
				$words[] = $new_word;

				if(isset($morphs)) {
					$morphs[] = $wordMorph . $affix->getMorphDescription();
				}

				$maxRemoveLength = max($maxRemoveLength, $affix->getRemoveLength());
			}
		}

		return $maxRemoveLength;
	}

	function addAffix($find, $remove, $append, $morph = null) {
		$this->affixes[] = $this->createAffix(
			$find, $remove, $append, $morph
		);
	}

	abstract protected function createAffix($find, $remove, $append, $morph);
	abstract function isSuffix();
}