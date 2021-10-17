<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_Aot_Mrd_File {
	protected
		$flexias,
		$accents,
		$sessions,
		$prefixes,
		$lemmas
		;

	function __construct($fileName, $encoding) {
		$line = 0;
		$this->initSections($line, $fileName, $encoding);
	}

	protected function initSections(&$startLine, $fileName, $encoding) {
		foreach($this->getSectionsNames() as $sectionName) {
			try {
				$section = $this->createNewSection(
					$sectionName,
					$fileName,
					$encoding,
					$startLine
				);

				$this->$sectionName = $section;
			} catch(Exception $e) {
				throw new phpMorphy_Aot_Mrd_Exception("Can`t init '$sectionName' section: " . $e->getMessage());
			}
		}
	}

	protected function createNewSection($sectionName, $fileName, $encoding, &$lineNo) {
		$sect_clazz = $this->getSectionClassName($sectionName);

		$section = new $sect_clazz($this->openFile($fileName), $encoding, $lineNo);
		$lineNo += $section->getSectionLinesCount();

		return $section;
	}

	protected function getSectionsNames() {
		return array(
			'flexias',
			'accents',
			'sessions',
			'prefixes',
			'lemmas'
		);
	}

	protected function openFile($fileName) {
		return new SplFileObject($fileName);
	}

	protected function getSectionClassName($sectionName) {
		return 'phpMorphy_Aot_Mrd_Section_' . ucfirst(strtolower($sectionName));
	}

	function __get($propName) {
		if(!preg_match('/^\w+_section$/', $propName)) {
			throw new phpMorphy_Aot_Mrd_Exception("Unsupported prop name given $propName");
		}

		list($sect_name) = explode('_', $propName);

		if(!isset($this->$sect_name)) {
			throw new phpMorphy_Aot_Mrd_Exception("Invalid section name given $propName");
		}

		return $this->$sect_name;
	}
}