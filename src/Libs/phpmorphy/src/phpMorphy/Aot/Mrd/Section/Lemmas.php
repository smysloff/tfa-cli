<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_Aot_Mrd_Section_Lemmas extends phpMorphy_Aot_Mrd_SectionAbstract {
	protected function processLine($line) {
		//if(6 != count($tokens = array_map('trim', explode(' ', $line)))) {
		$line = $this->iconv($line);

		if(6 != count($tokens = explode(' ', $line))) {
			throw new phpMorphy_Aot_Mrd_Exception("Invalid lemma str('$line'), too few tokens");
		}

		$base = trim($tokens[0]);

		if($base === '#') {
			$base = '';
		}

		$lemma = new phpMorphy_Dict_Lemma(
			$base, //$this->iconv(trim($tokens[0])), // base
			(int)$tokens[1], // flexia_id
			(int)$tokens[2] // accent_id
		);

		if('-' !== $tokens[4]) {
			$lemma->setAncodeId($tokens[4]);
		}

		if('-' !== $tokens[5]) {
			$lemma->setPrefixId((int)$tokens[5]);
		}

		return $lemma;
	}
}