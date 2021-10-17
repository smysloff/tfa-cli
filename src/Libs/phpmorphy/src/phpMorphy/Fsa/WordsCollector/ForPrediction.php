<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_Fsa_WordsCollector_ForPrediction extends phpMorphy_Fsa_WordsCollector {
    protected
        $used_poses = array(),
        $annot_decoder,
        $collected = 0;

    function __construct($limit, phpMorphy_AnnotDecoder_AnnotDecoderInterface $annotDecoder) {
        parent::__construct($limit);

        $this->annot_decoder = $annotDecoder;
    }

    function collect($path, $annotRaw) {
        if($this->collected > $this->limit) {
            return false;
        }

        $used_poses =& $this->used_poses;
        $annots = $this->decodeAnnot($annotRaw);

        for($i = 0, $c = count($annots); $i < $c; $i++) {
            $annot = $annots[$i];
            $annot['cplen'] = $annot['plen'] = 0;

            $pos_id = $annot['pos_id'];

            if(isset($used_poses[$pos_id]) && false) {
                $result_idx = $used_poses[$pos_id];

                if($annot['freq'] > $this->items[$result_idx]['freq']) {
                    $this->items[$result_idx] = $annot;
                }
            } else {
                $used_poses[$pos_id] = count($this->items);
                $this->items[] = $annot;
            }
        }

        $this->collected++;
        return true;
    }

    function clear() {
        parent::clear();
        $this->collected = 0;
        $this->used_poses = array();
    }

    function decodeAnnot($annotRaw) {
        return $this->annot_decoder->decode($annotRaw, true);
    }
}