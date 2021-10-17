<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_Aot_Mrd_Section_Flexias extends phpMorphy_Aot_Mrd_SectionAbstract {
	const COMMENT_STRING = 'q//q';

	protected function processLine($line) {
		$line = $this->iconv($this->removeComment($line));

		$model = new phpMorphy_Dict_FlexiaModel($this->getPosition());

		foreach(explode('%', substr($line, 1)) as $token) {
			//$parts = array_map('trim', explode('*', $token));
			$parts = explode('*', $token);

			switch(count($parts)) {
				case 2:
					$ancode = $parts[1];
					$prefix = '';
					break;
				case 3:
					$ancode = $parts[1];
					$prefix = $parts[2];
					break;
				default:
					throw new phpMorphy_Aot_Mrd_Exception("Invalid flexia string($token) in str($line)");
			}

			$flexia = $parts[0];

			$model->append(
				new phpMorphy_Dict_Flexia(
					$prefix, //$this->iconv($prefix),
					$flexia, //$this->iconv($flexia),
					$ancode
				)
			);
		}

		return $model;
	}

	protected function removeComment($line) {
		if(false !== ($pos = strrpos($line, self::COMMENT_STRING))) {
			return rtrim(substr($line, 0, $pos));
		} else {
			return $line;
		}
	}
}