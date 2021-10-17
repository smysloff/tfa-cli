<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_Util_Hunspell_DictFile {
	protected
		$file_name,
		$affix,
		$encoding
		;

	function __construct($fileName, phpMorphy_Util_Hunspell_AffixFile $affixFile, $encoding = null) {
		$this->file_name = $fileName;
		$this->affix = $affixFile;

		if($encoding === null) {
			try {
				$encoding = $affixFile->getEncoding();
			} catch(Exception $e) {
				throw new phpMorphy_Util_Hunspell_Exception("You must explicit specifiy encoding, because affix file dosn`t contain encoding");
			}
		}

		$this->encoding = $encoding;
	}

	protected function createDictReader() {
		return new phpMorphy_Util_Hunspell_DictFileReader($this->file_name, $this->encoding);
	}

	function export($callback) {
		$reader = $this->createDictReader();
		$reader->rewind();

		if($reader->valid()) {
			$tokens = $reader->current();

			if(preg_match('~^[0-9]+$~', $tokens['word'])) {
				$reader->next();
			}
		}

		while($reader->valid()) {
			$result = $reader->current();
			$reader->next();

			$all_words = $this->generateWordForms($result['word'], $result['morph'], $result['flags']);

			if(false === call_user_func($callback, $result['word'], $all_words['lemma'], $all_words['words'], $all_words['morphs'])) {
				break;
			}
		}
	}

	protected function generateWordForms($base, $baseMorph, $flagsList) {
		$prefix_flags = array();
		$suffix_flags = array();

		foreach($flagsList as $flag) {
			if($this->affix->isFlagExists($flag)) {
				$flag_obj = $this->affix->getFlag($flag);

				if($flag_obj->isSuffix()) {
					$suffix_flags[$flag] = $flag_obj;
				} else {
					$prefix_flags[$flag] = $flag_obj;
				}
			}
		}

		$words = array($base);
		$morphs = array($baseMorph);
		$lemma = '';

		// process prefixes
		$max_prefix_removed = $this->generateWordsForAffixes($base, $prefix_flags, $words, $baseMorph, $morphs);
		// process suffixes
		$max_suffix_removed = $this->generateWordsForAffixes($base, $suffix_flags, $words, $baseMorph, $morphs);

		if($max_suffix_removed) {
			$lemma = mb_substr($base, $max_prefix_removed, -$max_suffix_removed);
		} else {
			$lemma = mb_substr($base, $max_prefix_removed);
		}

		// process cross product
		if(count($prefix_flags) && count($suffix_flags)) {
			foreach($prefix_flags as $prefix) {
				if($prefix->isCrossProduct()) {
					$prefixed_bases = array();
					$prefixed_morphs = array();
					$prefix->generateWords($base, $prefixed_bases, $baseMorph, $prefixed_morphs);

					if(count($prefixed_bases)) {
						foreach($suffix_flags as $suffix) {
							if($suffix->isCrossProduct()) {
								$i = 0;
								foreach($prefixed_bases as $prefixed_base) {
									$suffix->generateWords($prefixed_base, $words, $prefixed_morphs[$i], $morphs);
									$i++;
								}
							}
						}
					}
				}
			}
		}

		return array(
			'words' => $words,
			'morphs' => $morphs,
			'lemma' => $lemma
		);
	}

	protected function generateWordsForAffixes($base, $affixes, &$words, $wordMorph, &$morphs) {
		$max_removed = 0;

		foreach($affixes as $affix) {
			$removed_length = $affix->generateWords($base, $words, $wordMorph, $morphs);

			$max_removed = max($removed_length, $max_removed);
		}

		return $max_removed;
	}
}