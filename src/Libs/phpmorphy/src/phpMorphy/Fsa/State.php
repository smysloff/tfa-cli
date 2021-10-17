<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_Fsa_State {
	protected
		$fsa,
		$transes,
		$raw_transes;

	function phpMorphy_Fsa_State(phpMorphy_Fsa_FsaInterface $fsa, $index) {
		$this->fsa = $fsa;

		$this->raw_transes = $fsa->readState($index);
		$this->transes = $fsa->unpackTranses($this->raw_transes);
	}

	function getLinks() {
		$result = array();

		for($i = 0, $c = count($this->transes); $i < $c; $i++) {
			$trans = $this->transes[$i];

			if(!$trans['term']) {
				$result[] = $this->createNormalLink($trans, $this->raw_transes[$i]);
			} else {
				$result[] = $this->createAnnotLink($trans, $this->raw_transes[$i]);
			}
		}

		return $result;
	}

	function getSize() { return count($this->transes); }

	protected function createNormalLink($trans, $raw) {
		return new phpMorphy_Fsa_Link($this->fsa, $trans, $raw);
	}

	protected function createAnnotLink($trans, $raw) {
		return new phpMorphy_Fsa_LinkAnnot($this->fsa, $trans, $raw);
	}
};