<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_Finder_Fsa_PredictBySuffix extends phpMorphy_Finder_Fsa_Finder {
    protected
        $min_suf_len,
        $unicode;

    function __construct(phpMorphy_Fsa_FsaInterface $fsa, phpMorphy_AnnotDecoder_AnnotDecoderInterface $annotDecoder, $encoding, $minimalSuffixLength = 4) {
        parent::__construct($fsa, $annotDecoder);

        $this->min_suf_len = (int)$minimalSuffixLength;
        $this->unicode = phpMorphy_UnicodeHelper_UnicodeHelperAbstract::getHelperForEncoding($encoding);
    }

    protected function doFindWord($word) {
        $word_len = $this->unicode->strlen($word);

        if(!$word_len) {
            return false;
        }

        $skip_len = 0;

        for($i = 1, $c = $word_len - $this->min_suf_len; $i < $c; $i++) {
            $first_char_size = $this->unicode->getFirstCharSize($word);
            $skip_len += $first_char_size;

            $word = $GLOBALS['__phpmorphy_substr']($word, $first_char_size);

            if(false !== ($result = parent::doFindWord($word))) {
                break;
            }
        }

        if($i < $c) {
            return $this->fixAnnots(
                $this->decodeAnnot($result, true),
                $skip_len
            );
        } else {
            return false;
        }
    }

    protected function fixAnnots($annots, $len) {
        for($i = 0, $c = count($annots); $i < $c; $i++) {
            $annots[$i]['cplen'] += $len;
        }

        return $annots;
    }
}