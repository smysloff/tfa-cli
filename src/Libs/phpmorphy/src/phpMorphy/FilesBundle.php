<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_FilesBundle {
    protected
        /** @var string */
        $dir,
        /** @var string */
        $lang;

    /**
     * @param string $dirName
     * @param string $lang
     */
    function __construct($dirName, $lang) {
        $this->dir = rtrim($dirName, "\\/" . DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
        $this->setLang($lang);
    }

    /**
     * @return string
     */
    function getDirectory() {
        return $this->dir;
    }

    /**
     * @return string
     */
    function getLang() {
        return $this->lang;
    }

    /**
     * @param string $lang
     * @return void
     */
    function setLang($lang) {
        //$this->lang = $GLOBALS['__phpmorphy_strtolower']($lang);
        $this->lang = strtolower($lang);
    }

    /**
     * @return string
     */
    function getCommonAutomatFile() {
        return $this->genFileName('common_aut');
    }

    /**
     * @return string
     */
    function getPredictAutomatFile() {
        return $this->genFileName('predict_aut');
    }

    /**
     * @return string
     */
    function getGramInfoFile() {
        return $this->genFileName('morph_data');
    }

    /**
     * @return string
     */
    function getGramInfoAncodesCacheFile() {
        return $this->genFileName('morph_data_ancodes_cache');
    }

    /**
     * @return string
     */
    function getAncodesMapFile() {
        return $this->genFileName('morph_data_ancodes_map');
    }

    /**
     * @return string
     */
    function getGramTabFile() {
        return $this->genFileName('gramtab');
    }

    /**
     * @return string
     */
    function getGramTabFileWithTextIds() {
        return $this->genFileName('gramtab_txt');
    }

    /**
     * @param string $type
     * @return string
     */
    function getDbaFile($type) {
        if(!isset($type)) {
            $type = 'db3';
        }

        return $this->genFileName("common_dict_$type");
    }

    /**
     * @return string
     */
    function getGramInfoHeaderCacheFile() {
        return $this->genFileName('morph_data_header_cache');
    }

    /**
     * @param string $token
     * @param string|null $extraExt
     * @return string
     */
    protected function genFileName($token, $extraExt = null) {
        return $this->dir . $token . '.' . $this->lang . (isset($extraExt) ? '.' . $extraExt : '') . '.bin';
    }
}