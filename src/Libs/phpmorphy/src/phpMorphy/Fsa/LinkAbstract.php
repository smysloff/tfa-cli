<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

abstract class phpMorphy_Fsa_LinkAbstract {
	protected
		$fsa,
		$trans,
		$raw_trans;

	function phpMorphy_Fsa_LinkAbstract(phpMorphy_Fsa_FsaInterface $fsa, $trans, $rawTrans) {
		$this->fsa = $fsa;
		$this->trans = $trans;
		$this->raw_trans = $rawTrans;
	}

	function isAnnotation() { }
	function getTrans() { return $this->trans; }
	function getFsa() { return $this->fsa; }
	function getRawTrans() { return $this->raw_trans; }
};