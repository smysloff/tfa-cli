<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_Dict_GramTab_ConstStorage_Loader {
    const INTERNAL_ENCODING = 'utf-8';
    const USE_CACHING = false;

    protected
        /* @var SimpleXMLElement */
        $xml,
        $cache = array()
        ;

    function __construct($fileName) {
        if(false === ($this->xml = $xml = simplexml_load_file($fileName))) {
            throw new Exception("Can`t parse map xml file '$fileName'");
        }
    }

    function getLanguage() {
        return (string)$this->xml->options->lang;
    }

    function getLanguageShort() {
        return (string)$this->xml->options->lang_short;
    }

    function getPartsOfSpeech() {
        return $this->invokeAndPutInCache('readPoses');
    }

    function getGrammems() {
        return $this->invokeAndPutInCache('readGrammems');
    }

    function getMetaGrammems() {
        return $this->invokeAndPutInCache('readMetaGrammems');
    }

    private function invokeAndPutInCache($method) {
        if(self::USE_CACHING) {
            $tag = $method;

            if(!isset($this->cache[$tag])) {
                $this->cache[$tag] = $this->$method();
            }

            return $this->cache[$tag];
        } else {
            return $this->$method();
        }
    }

    private function createKeyedArray($ary, $keyName) {
        $result = array();
        foreach($ary as $k => $item) {
            $key = $item[$keyName];

            if(isset($result[$key])) {
                throw new Exception("Duplicate key '$key' found");
            }

            $result[$key] = & $ary[$k];
        }

        return $result;
    }

    private function readMetaGrammems() {
        $xml = $this->xml;
        $grammems = $this->getGrammems();

        $meta = array();

        if(!isset($xml->meta_grammems->grammem) || !count($grammems)) {
            return array();
        }

        $grammems_by_const = $this->createKeyedArray($grammems, 'const');
        $grammems_by_id = $this->createKeyedArray($grammems, 'id');

        /*
          $ids = array_keys($grammems_by_id);
          sort($ids, SORT_DESC);
          $max_id = $ids[0] + 1;
         */

        foreach($xml->meta_grammems->grammem as $grammem) {
            $const_name = $this->convertCase($grammem['const_name']);

            $grammems_list = array();
            foreach($grammem->const as $const) {
                if(isset($const['const_name'])) {
                    $key = (string) $const['const_name'];

                    if(!isset($grammems_by_const[$key])) {
                        throw new Exception("Unknown grammem const '$key' found'");
                    }

                    $grammems_list[] = $key;
                } else if(isset($const['id'])) {
                    $key = (string) $const['id'];

                    if(!isset($grammems_by_id[$key])) {
                        throw new Exception("Unknown grammem id '$key' found'");
                    }

                    $grammems_list[] = $grammems_by_id[$key]['const'];
                } else {
                    throw new Exception("Specify id or name const_name attribute for <const> elt");
                }
            }

            $meta[$const_name] = array(
                'const' => $const_name,
                'consts_list' => $grammems_list
            );
        }

        return $meta;
    }

    private function readGrammems() {
        $xml = $this->xml;

        if(!isset($xml->grammems->grammem)) {
            return array();
        }

        $grammems = array();
        $grammems_ids = array();

        foreach($xml->grammems->grammem as $grammem) {
            $id = (string) $grammem['id'];
            $name = $this->convertCase($grammem['name']);
            $const_name = $this->convertCase($grammem['const_name']);

            $grammems[(string)$name] = array(
                'name' => $name,
                'id' => $id,
                'shift' => (string) $grammem['shift'],
                'const' => $const_name
            );

            $grammems_ids[] = $id;
        }

        if(count(array_unique($grammems_ids)) != count($grammems_ids)) {
            throw new Exception("Duplicate grammem id found in '$fileName' file");
        }

        return $grammems;
    }

    private function readPoses() {
        $xml = $this->xml;

        if(!isset($xml->part_of_speech->pos)) {
            return array();
        }

        $poses = array();
        $poses_ids = array();
        foreach($xml->part_of_speech->pos as $pos) {
            $id = (string) $pos['id'];
            $name = $this->convertCase($pos['name']);
            $const_name = $this->convertCase($pos['const_name']);

            $poses[(string)$name] = array(
                'name' => $name,
                'id' => $id,
                'const' => $const_name
            );

            $poses_ids[] = $id;
        }

        if(count(array_unique($poses_ids)) != count($poses_ids)) {
            throw new Exception("Duplicate part of speech id found in '$fileName' file");
        }

        return $poses;
    }

    private function convertCase($str) {
        return mb_convert_case((string) $str, MB_CASE_UPPER, self::INTERNAL_ENCODING);
    }

}