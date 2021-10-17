<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_Aot_Mrd_Section_Prefixes extends phpMorphy_Aot_Mrd_SectionAbstract {
	protected function processLine($line) {
		$line = $this->iconv($line);

		$result = new phpMorphy_Dict_PrefixSet($this->getPosition());

		$result->import(
			new ArrayIterator(
				array_map('trim', explode(',', $line))
			)
		);

		return $result;
	}
}