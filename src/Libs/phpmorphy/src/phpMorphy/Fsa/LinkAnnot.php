<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_Fsa_LinkAnnot extends phpMorphy_Fsa_LinkAbstract {
	function isAnnotation() { return true; }

	function getAnnotation() {
		return $this->fsa->getAnnot($this->raw_trans);
	}
};