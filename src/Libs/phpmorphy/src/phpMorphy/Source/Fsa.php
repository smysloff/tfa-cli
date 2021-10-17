<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_Source_Fsa implements phpMorphy_Source_SourceInterface {
    protected
        /** @var phpMorphy_Fsa_FsaInterface */
        $fsa,
        /** @var int */
        $root;

    /**
     * @param phpMorphy_Fsa_FsaInterface $fsa
     */
    function __construct(phpMorphy_Fsa_FsaInterface $fsa) {
        $this->fsa = $fsa;
        $this->root = $fsa->getRootTrans();
    }

    /**
     * @return phpMorphy_Fsa_FsaInterface
     */
    function getFsa() {
    	return $this->fsa;
    }

    /**
     * @param string $key
     * @return string|false
     */
    function getValue($key) {
        if(false === ($result = $this->fsa->walk($this->root, $key, true)) || !$result['annot']) {
            return false;
        }

        return $result['annot'];
    }
}