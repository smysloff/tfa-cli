<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_Aot_MrdManager {
	protected
		$opened = false,
		$language,
		$encoding,
		$mrd,
		$gram_info;

	function open($filePath) {
		$mwz = $this->openMwz($filePath);
		$this->encoding = $mwz->getEncoding();
		$mrd_path = $mwz->getMrdPath();
		$language = $mwz->getLanguage();

		$this->mrd = $this->openMrd($mrd_path, $this->encoding);

		$this->gram_info = $this->convertFromGramtabToDict(
			$this->openGramTab($language, $this->encoding)
		);

		$this->language = $language;
		$this->opened = true;
	}

	function isOpened() {
		return $this->opened;
	}

	protected function checkOpened() {
		if(!$this->isOpened()) {
			throw new phpMorphy_Aot_Mrd_Exception(__CLASS__ . " not initialized, use open() method");
		}
	}

	function getEncoding() {
		$this->checkOpened();
		return $this->getEncoding();
	}

	function getLanguage() {
		$this->checkOpened();
		return $this->language;
	}

	function getMrd() {
		$this->checkOpened();
		return $this->mrd;
	}

	function getGramInfo() {
		$this->checkOpened();
		return $this->gram_info;
	}

	protected function convertFromGramtabToDict($ancodes) {
		$result = array();

		foreach($ancodes as $ancode) {
			$ancode_id = $ancode->getAncodeId();

			$result[$ancode_id] = new phpMorphy_Dict_Ancode(
				$ancode_id,
				$ancode->getPartOfSpeech(),
				$ancode->isPartOfSpeechProductive(),
				$ancode->getGrammems()
			);
		}

		return new ArrayIterator($result);
	}

	protected function openMwz($wmzFile) {
		return new phpMorphy_Aot_Mwz_File($wmzFile);
	}

	protected function openMrd($path, $encoding) {
		return new phpMorphy_Aot_Mrd_File($path, $encoding);
	}

	protected function openGramTab($lang, $encoding) {
		try {
			return $this->createGramTabFile(
				$this->getGramTabPath($lang),
				$encoding,
				$this->createGramInfoFactory($lang)
			);
		} catch(Exception $e) {
			throw new phpMorphy_Aot_Mrd_Exception('Can`t parse gramtab file: ' . $e->getMessage());
		}
	}

	protected function getGramTabPath($lang) {
		$rml = new phpMorphy_Aot_Rml_IniFile();

		return $rml->getGramTabPath($lang);
	}

	protected function createGramInfoFactory($lang) {
		return new phpMorphy_Aot_GramTab_GramInfoFactory(
            phpMorphy_Aot_GramTab_GramInfoHelperAbstract::createByLanguage($lang)
        );
	}

	protected function createGramTabFile($file, $encoding, phpMorphy_Aot_GramTab_GramInfoFactory $factory) {
		return new phpMorphy_Aot_GramTab_File($file, $encoding, $factory);
	}
}