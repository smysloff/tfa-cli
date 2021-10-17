<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_Fsa_Link extends phpMorphy_Fsa_LinkAbstract {
	function isAnnotation() { return false; }

	function getDest() { return $this->trans['dest']; }
	function getAttr() { return $this->trans['attr']; }

	function getTargetState() {
		return $this->createState($this->trans['dest']);
	}

	protected function createState($index) {
		return new phpMorphy_Fsa_State($this->fsa, $index);
	}
}