<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_Util_Hunspell_AffixFile {
	protected
		$flags = array(),
		$options = array();

	function __construct($fileName, $options = array()) {
		$this->options = $options;
		$this->parseFile($fileName);
	}

	function isFlagExists($name) {
		return array_key_exists($name, $this->flags);
	}

	function getFlag($name) {
		if(!$this->isFlagExists($name)) {
			throw new phpMorphy_Util_Hunspell_Exception("Unknown $name flag");

			return false;
		}

		return $this->flags[$name];
	}

	function getOptions() {
		return $this->options;
	}

	function isOptionExists($name) {
		return array_key_exists($name, $this->options);
	}

	function getOption($name) {
		if(!$this->isOptionExists($name)) {
			throw new phpMorphy_Util_Hunspell_Exception("Unknown $name option");
		}

		return $this->options[$name];
	}

	function getEncoding() {
		try {
			return $this->getOption('SET');
		} catch(Exception $e) {
			throw new phpMorphy_Util_Hunspell_Exception("Can`t return encoding, because SET option not exists");
		}
	}

	protected function parseFile($fileName) {
		$default_enc = $this->isOptionExists('SET') ? $this->getOption('SET') : null;

		$reader = $this->createAffixReader($fileName, $default_enc);
		$reader->rewind();

		try {
			while($reader->valid()) {
				$tokens = $reader->current();

				$this->processLine($tokens, $reader);

				$reader->next();

				// HACK: $this->options['SET'] for perfomance
				if(!isset($default_enc) && isset($this->options['SET'])) {
					$default_enc = $this->getOption('SET');

					$reader->setEncoding($default_enc);
				}
			}
		} catch(Exception $e) {
			throw new phpMorphy_Util_Hunspell_Exception("Can`t parse $fileName affix file, error at " . $reader->key() . " line: " . $e->getMessage());
		}
	}

	protected function createAffixReader($fileName, $defaultEncoding) {
		return new phpMorphy_Util_Hunspell_AffixFileReader($fileName, $defaultEncoding);
	}

	protected function processLine($tokens, Iterator $reader) {
		$type = $tokens[0];

		if($type == 'SFX' || $type == 'PFX') {
			if(count($tokens) < 4) {
				throw new phpMorphy_Util_Hunspell_Exception("Invalid affix header");
			}

			$this->readAffixBlock($reader, $type, $tokens[1], $tokens[3], $tokens[2]);
		} else {
			array_shift($tokens);
			$this->handleOption($type, $tokens);
		}
	}

	protected function readAffixBlock(Iterator $reader, $type, $flagName, $count, $crossProduct) {
		$affix_flag = $this->createAffixFlag($type, $flagName, $crossProduct == 'Y');

		for($i = 0; $i < $count; $i++) {
			$reader->next();

			if(!$reader->valid()) {
				throw new phpMorphy_Util_Hunspell_Exception("Unexpected file end while reading '" . $flagName . "' flag, " . ($count - $i) . " items needed");
			}

			$tokens = $reader->current();

			if(count($tokens) < 5 || $tokens[0] != $type || $tokens[1] != $flagName) {
				throw new phpMorphy_Util_Hunspell_Exception("Invalid line type given, proper affix expected");
			}

			$append = $tokens[3] == '0' ? '' : $tokens[3];
			if(strpos($append, '/') !== false) {
				throw new phpMorphy_Util_Hunspell_Exception("Affix continuation not supported");
			}

			$affix_flag->addAffix(
				$tokens[4],
				$tokens[2] == '0' ? '' : $tokens[2],
				$append,
				isset($tokens[5]) ? $tokens[5] : null
			);
		}

		$this->flags[$flagName] = $affix_flag;
	}

	protected function createAffixFlag($type, $flagName, $crossProduct) {
		return phpMorphy_Util_Hunspell_AffixFlagAbstract::create(
			$type,
			$flagName,
			$crossProduct == 'Y'
		);
	}

	protected function handleOption($type, $options) {
		if(!$this->isAllowedOption($type, $options)) {
			throw new phpMorphy_Util_Hunspell_Exception("Sorry, option '$type' not supported now");
		}

		if(count($options) == 1) {
			$options = $options[0];
		}

		/*
		if(!array_key_exists($type, $this->options)) {
			$this->options[$type] = $options;
		}
		*/
		$this->options[$type] = $options;
	}

	protected function isAllowedOption($type, $options) {
		return !in_array(
			$type,
			array(
				'FLAG', // FLAGS not supported
				'AF',
				'AM'
			)
		);
	}
}