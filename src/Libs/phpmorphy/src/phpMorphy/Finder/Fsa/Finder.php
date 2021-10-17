<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */



class phpMorphy_Finder_Fsa_Finder extends phpMorphy_Finder_FinderAbstract {
    protected
        $fsa,
        $root;

    function __construct(phpMorphy_Fsa_FsaInterface $fsa, phpMorphy_AnnotDecoder_AnnotDecoderInterface $annotDecoder) {
        parent::__construct($annotDecoder);

        $this->fsa = $fsa;
        $this->root = $this->fsa->getRootTrans();
    }

    function getFsa() {
        return $this->fsa;
    }

    protected function doFindWord($word) {
        $result = $this->fsa->walk($this->root, $word);

        if(!$result['result'] || null === $result['annot']) {
            return false;
        }

        return $result['annot'];
    }
}