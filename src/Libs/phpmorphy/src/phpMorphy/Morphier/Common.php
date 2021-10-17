<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_Morphier_Common extends phpMorphy_Morphier_MorphierAbstract {
    function __construct(phpMorphy_Fsa_FsaInterface $fsa, phpMorphy_Helper $helper) {
        parent::__construct(
            new phpMorphy_Finder_Fsa_Finder(
                $fsa,
                $this->createAnnotDecoder($helper)
            ),
            $helper
        );
    }

    protected function createAnnotDecoder(phpMorphy_Helper $helper) {
        return phpMorphy_AnnotDecoder_Factory::instance($helper->getEndOfString())->getCommonDecoder();
    }
};