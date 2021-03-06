<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_Dict_GramTab_ConstStorage {
    protected
        $lang,
        $lang_short,
        $poses_map,
        $grammems_map,
        $meta_grammems_map;

    function __construct(
        phpMorphy_Dict_GramTab_ConstStorage_Loader $loader
    ) {
        $this->lang = $loader->getLanguage();
        $this->lang_short = $loader->getLanguageShort();

        $this->poses_map = $loader->getPartsOfSpeech();
        $this->grammems_map = $loader->getGrammems();
        $this->meta_grammems_map = $loader->getMetaGrammems();
    }

    function merge(phpMorphy_Dict_GramTab_ConstStorage $other) {
        if(true !== ($error = $this->checkForIdIntersection($this->poses_map, $other->getPosesMap(), 'Part of speech'))) {
            throw new Exception($error);
        }

        if(true !== ($error = $this->checkForIdIntersection($this->grammems_map, $other->getGrammemsMap(), 'Grammem'))) {
            throw new Exception($error);
        }

        $this->poses_map = array_merge($this->poses_map, $other->getPosesMap());
        $this->grammems_map = array_merge($this->grammems_map, $other->getGrammemsMap());
        $this->meta_grammems_map = array_merge($this->meta_grammems_map, $other->getMetaGrammemsMap());

        // reassign ids due to array_merge reorder numeric keys
        $this->poses_map = $this->assignKeysFromName($this->poses_map);
        $this->grammems_map = $this->assignKeysFromName($this->grammems_map);
    }

    private function assignKeysFromName($array) {
        $result = array();

        foreach($array as $key => $value) {
            $result[$value['name']] = $value;
        }

        return $result;
    }

    private function checkForIdIntersection($ary1, $ary2, $type) {
        $ary2_ids = array();
        foreach($ary2 as $key => $item) {
            $ary2_ids[$item['id']] = $key;
        }

        foreach($ary1 as $key => $item) {
            $id = $item['id'];

            if(isset($ary2_ids[$id])) {
                $intersets_with_key = $ary2_ids[$id];

                $ary1_name = $item['name'];
                $ary2_name = $ary2[$intersets_with_key]['name'];

                return "$type '$ary1_name' interects with '$ary2_name'";
            }
        }

        return true;
    }

    function getLanguage() {
        return $this->lang;
    }

    function getLanguageShort() {
        return $this->lang_short;
    }

    function getGrammemsMap() {
        return $this->grammems_map;
    }

    function getPosesMap() {
        return $this->poses_map;
    }

    function getMetaGrammemsMap() {
        return $this->meta_grammems_map;
    }

    function getGrammemsConsts() {
        return $this->getConsts($this->grammems_map);
    }

    function getPosesConsts() {
        return $this->getConsts($this->poses_map);
    }

    protected function getConsts($map) {
        $result = array();

        foreach($map as $item) {
            $result[$item['id']] = $item['const'];
        }

        return $result;
    }

    function getPartOfSpeechIdByName($name) {
        $result = $this->getMapItem($this->poses_map, $name, 'part of speech');
        return $result['id'];
    }

    function getGrammemIdByName($name) {
        $result = $this->getMapItem($this->grammems_map, $name, 'grammem');
        return $result['id'];
    }

    function getGrammemShiftByName($name) {
        $result = $this->getMapItem($this->grammems_map, $name, 'grammem');
        return $result['shift'];
    }

    function hasGrammemName($name) {
        return isset($this->grammems_map[$name]);
    }

    function hasPartOfSpeechName($name) {
        return isset($this->poses_map[$name]);
    }

    protected function getMapItem($map, $name, $type) {
        if(isset($map[$name])) {
            return $map[$name];
        } else {
            $lang = $this->getLanguage();
            throw new Exception("Unknown gramtab symbol($type) '$name' found, for '$lang' language");
        }
    }

}