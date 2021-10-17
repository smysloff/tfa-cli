<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

abstract class phpMorphy_GrammemsProvider_GrammemsProviderAbstract implements phpMorphy_GrammemsProvider_GrammemsProviderInterface {
    protected
        /** @var string[] */
        $all_grammems,
        /** @var array */
        $grammems = array();

    function __construct() {
        $this->all_grammems = $this->flatizeArray($this->getAllGrammemsGrouped());
    }

    /**
     * @abstract
     * @return array
     */
    abstract function getAllGrammemsGrouped();

    /**
     * @param string $partOfSpeech
     * @param array $names
     * @return phpMorphy_GrammemsProvider_GrammemsProviderAbstract
     */
    function includeGroups($partOfSpeech, $names) {
        $grammems = $this->getAllGrammemsGrouped();
        $names = array_flip((array)$names);

        foreach(array_keys($grammems) as $key) {
            if(!isset($names[$key])) {
                unset($grammems[$key]);
            }
        }

        $this->grammems[$partOfSpeech] = $this->flatizeArray($grammems);

        return $this;
    }

    /**
     * @param string $partOfSpeech
     * @param array $names
     * @return phpMorphy_GrammemsProvider_GrammemsProviderAbstract
     */
    function excludeGroups($partOfSpeech, $names) {
        $grammems = $this->getAllGrammemsGrouped();

        foreach((array)$names as $key) {
            unset($grammems[$key]);
        }

        $this->grammems[$partOfSpeech] = $this->flatizeArray($grammems);

        return $this;
    }

    /**
     * @param string $partOfSpeech
     * @return phpMorphy_GrammemsProvider_GrammemsProviderAbstract
     */
    function resetGroups($partOfSpeech) {
        unset($this->grammems[$partOfSpeech]);
        return $this;
    }

    /**
     * @return phpMorphy_GrammemsProvider_GrammemsProviderAbstract
     */
    function resetGroupsForAll() {
        $this->grammems = array();
        return $this;
    }

    /**
     * @static
     * @param array $array
     * @return array
     */
    static function flatizeArray($array) {
        return call_user_func_array('array_merge', $array);
    }

    /**
     * @param string $partOfSpeech
     * @return array
     */
    function getGrammems($partOfSpeech) {
        if(isset($this->grammems[$partOfSpeech])) {
            return $this->grammems[$partOfSpeech];
        } else {
            return $this->all_grammems;
        }
    }
}