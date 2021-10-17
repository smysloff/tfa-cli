<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_Aot_Mrd_Section_Accents extends phpMorphy_Aot_Mrd_SectionAbstract {
	const UNKNOWN_ACCENT_VALUE = 255;

	protected function processLine($line) {
		if(substr($line, -1, 1) == ';') {
			$line = substr($line, 0, -1);
		}

		$result = new phpMorphy_Dict_AccentModel($this->getPosition());
		$result->import(
			new ArrayIterator(
				array_map(
					array($this, 'processAccentValue'),
					explode(';', $line)
				)
			)
		);

		return $result;
	}

	protected function processAccentValue($item) {
		$item = (int)$item;

		if($item == self::UNKNOWN_ACCENT_VALUE) {
			$item = null;
		}

		return $item;
	}
}