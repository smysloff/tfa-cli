<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_GramInfo_File extends phpMorphy_GramInfo_GramInfoAbstract {
    function getGramInfoHeaderSize() {
        return 20;
    }

    function readGramInfoHeader($offset) {
        $__fh = $this->resource;
        fseek($__fh, $offset);
        $result = unpack(
            'vid/vfreq/vforms_count/vpacked_forms_count/vancodes_count/vancodes_offset/vancodes_map_offset/vaffixes_offset/vaffixes_size/vbase_size',
            fread($__fh, 20)        );

        $result['offset'] = $offset;

        return $result;
    }

    protected function readAncodesMap($info) {
        $__fh = $this->resource;

        // TODO: this can be wrong due to aligning ancodes map section
        $offset = $info['offset'] + 20 + $info['forms_count'] * 2;

        fseek($__fh, $offset);
        $forms_count = $info['packed_forms_count'];
        return unpack("v$forms_count",  fread($__fh, $forms_count * 2));
    }

    protected function splitAncodes($ancodes, $map) {
        $result = array();
        for($i = 1, $c = count($map), $j = 1; $i <= $c; $i++) {
            $res = array();

            for($k = 0, $kc = $map[$i]; $k < $kc; $k++, $j++) {
                $res[] = $ancodes[$j];
            }

            $result[] = $res;
        }

        return $result;
    }

    function readAncodes($info) {
        $__fh = $this->resource;

        // TODO: this can be wrong due to aligning ancodes section
        $offset = $info['offset'] + 20;

        fseek($__fh, $offset);
        $forms_count = $info['forms_count'];
        $ancodes = unpack("v$forms_count", fread($__fh, $forms_count * 2));

        /*
        if(!$expand) {
            return $ancodes;
        }
        */

        $map = $this->readAncodesMap($info);

        return $this->splitAncodes($ancodes, $map);
    }

    function readFlexiaData($info) {
        $__fh = $this->resource;

        $offset = $info['offset'] + 20;

        if(isset($info['affixes_offset'])) {
            $offset += $info['affixes_offset'];
        } else {
            $offset += $info['forms_count'] * 2 + $info['packed_forms_count'] * 2;
        }

        fseek($__fh, $offset);        return explode($this->ends, fread($__fh, $info['affixes_size'] - $this->ends_size));
    }

    function readAllGramInfoOffsets() {
        return $this->readSectionIndex($this->header['flex_index_offset'], $this->header['flex_count']);
    }

    protected function readSectionIndex($offset, $count) {
        $__fh = $this->resource;

        fseek($__fh, $offset);
        return array_values(unpack("V$count", fread($__fh, $count * 4)));
    }

    function readAllFlexia() {
        $__fh = $this->resource;

        $result = array();

        $offset = $this->header['flex_offset'];

        foreach($this->readSectionIndexAsSize($this->header['flex_index_offset'], $this->header['flex_count'], $this->header['flex_size']) as $size) {
            $header = $this->readGramInfoHeader($offset);
            $affixes = $this->readFlexiaData($header);
            $ancodes = $this->readAncodes($header, true);

            $result[$header['id']] = array(
                'header' => $header,
                'affixes' => $affixes,
                'ancodes' => $ancodes
            );

            $offset += $size;
        }

        return $result;
    }

    function readAllPartOfSpeech() {
        $__fh = $this->resource;

        $result = array();

        $offset = $this->header['poses_offset'];

        foreach($this->readSectionIndexAsSize($this->header['poses_index_offset'], $this->header['poses_count'], $this->header['poses_size']) as $size) {
            fseek($__fh, $offset);
            $res = unpack(
                'vid/Cis_predict',
                fread($__fh, 3)            );

            $result[$res['id']] = array(
                'is_predict' => (bool)$res['is_predict'],
                'name' => $this->cleanupCString(fread($__fh, $size - 3))
            );

            $offset += $size;
        }

        return $result;
    }

    function readAllGrammems() {
        $__fh = $this->resource;

        $result = array();

        $offset = $this->header['grammems_offset'];

        foreach($this->readSectionIndexAsSize($this->header['grammems_index_offset'], $this->header['grammems_count'], $this->header['grammems_size']) as $size) {
            fseek($__fh, $offset);
            $res = unpack(
                'vid/Cshift',
                fread($__fh, 3)            );

            $result[$res['id']] = array(
                'shift' => $res['shift'],

                'name' => $this->cleanupCString(fread($__fh, $size - 3))
            );

            $offset += $size;
        }

        return $result;
    }

    function readAllAncodes() {
        $__fh = $this->resource;

        $result = array();

        $offset = $this->header['ancodes_offset'];
        fseek($__fh, $offset);
        for($i = 0; $i < $this->header['ancodes_count']; $i++) {
            $res = unpack('vid/vpos_id', fread($__fh, 4));
            $offset += 4;

            list(, $grammems_count) = unpack('v', fread($__fh, 2));
            $offset += 2;

            $result[$res['id']] = array(
                'pos_id' => $res['pos_id'],
                'grammem_ids' => $grammems_count ?
                    array_values(unpack("v$grammems_count", fread($__fh, $grammems_count * 2))) :
                    array(),
                'offset' => $offset,
            );

            $offset += $grammems_count * 2;
        }

        return $result;
    }
}