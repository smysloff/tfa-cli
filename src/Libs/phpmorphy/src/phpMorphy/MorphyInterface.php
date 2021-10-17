<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

interface phpMorphy_MorphyInterface {
    const RESOLVE_ANCODES_AS_TEXT = 0;
    const RESOLVE_ANCODES_AS_DIALING = 1;
    const RESOLVE_ANCODES_AS_INT = 2;

    const NORMAL = 1;
    const IGNORE_PREDICT = 2;
    const ONLY_PREDICT = 3;

    const PREDICT_BY_NONE = 'none';
    const PREDICT_BY_SUFFIX = 'by_suffix';
    const PREDICT_BY_DB = 'by_db';

    /**
    * @return phpMorphy_Morphier_MorphierInterface
    */
    function getCommonMorphier();

    /**
    * @return phpMorphy_Morphier_MorphierInterface
    */
    function getPredictBySuffixMorphier();

    /**
    * @return phpMorphy_Morphier_MorphierInterface
    */
    function getPredictByDatabaseMorphier();

    /**
    * @return phpMorphy_Morphier_Bulk
    */
    function getBulkMorphier();

    /**
    * @return string
    */
    function getEncoding();

    /**
    * @return string
    */
    function getLocale();

    /**
     * @return bool
     */
    function isInUpperCase();

    /**
     * @return phpMorphy_GrammemsProvider_GrammemsProviderAbstract
     */
    function getGrammemsProvider();

    /**
     * @return phpMorphy_GrammemsProvider_GrammemsProviderAbstract
     */
    function getDefaultGrammemsProvider();

    /**
    * @return phpMorphy_Shm_Cache
    */
    function getShmCache();

    /**
    * @return bool
    */
    function isLastPredicted();

    /**
    * @return one of PREDICT_BY_NONE, PREDICT_BY_SUFFIX, PREDICT_BY_DB
    */
    function getLastPredictionType();

    /**
    * @param mixed $word - string or array of strings
    * @param mixed $type - prediction managment
    * @return phpMorphy_Paradigm_Collection
    */
    function findWord($word, $type = self::NORMAL);

    /**
    * Alias for getBaseForm
    *
    * @param mixed $word - string or array of strings
    * @param mixed $type - prediction managment
    * @return array
    */
    function lemmatize($word, $type = self::NORMAL);

    /**
    * @param mixed $word - string or array of strings
    * @param mixed $type - prediction managment
    * @return array
    */
    function getBaseForm($word, $type = self::NORMAL);

    /**
    * @param mixed $word - string or array of strings
    * @param mixed $type - prediction managment
    * @return array
    */
    function getAllForms($word, $type = self::NORMAL);

    /**
    * @param mixed $word - string or array of strings
    * @param mixed $type - prediction managment
    * @return array
    */
    function getPseudoRoot($word, $type = self::NORMAL);

    /**
    * @param mixed $word - string or array of strings
    * @param mixed $type - prediction managment
    * @return array
    */
    function getPartOfSpeech($word, $type = self::NORMAL);

    /**
    * @param mixed $word - string or array of strings
    * @param mixed $type - prediction managment
    * @return array
    */
    function getAllFormsWithAncodes($word, $type = self::NORMAL);

    /**
    * @param mixed $word - string or array of strings
    * @paradm bool $asText - represent graminfo as text or ancodes
    * @param mixed $type - prediction managment
    * @return array
    */
    function getAllFormsWithGramInfo($word, $asText = true, $type = self::NORMAL);

    /**
    * @param mixed $word - string or array of strings
    * @param mixed $type - prediction managment
    * @return array
    */
    function getAncode($word, $type = self::NORMAL);

    /**
    * @param mixed $word - string or array of strings
    * @param mixed $type - prediction managment
    * @return array
    */
    function getGramInfo($word, $type = self::NORMAL);

    /**
    * @param mixed $word - string or array of strings
    * @param mixed $type - prediction managment
    * @return array
    */
    function getGramInfoMergeForms($word, $type = self::NORMAL);

    /**
    * @param string $word
    * @param mixed $ancode
    * @param mixed $commonAncode
    * @param bool $returnOnlyWord
    * @param mixed $callback
    * @param mixed $type
    * @return array
    */
    function castFormByAncode($word, $ancode, $commonAncode = null, $returnOnlyWord = false, $callback = null, $type = self::NORMAL);

    /**
    * @param string $word
    * @param mixed $partOfSpeech
    * @param array $grammems
    * @param bool $returnOnlyWord
    * @param mixed $callback
    * @param mixed $type
    * @return array
    */
    function castFormByGramInfo($word, $partOfSpeech, $grammems, $returnOnlyWord = false, $callback = null, $type = self::NORMAL);

    /**
    * @param string $word
    * @param mixed $partOfSpeech
    * @param array $grammems
    * @param bool $returnOnlyWord
    * @param mixed $callback
    * @param mixed $type
    * @return array
    */
    //function castFormByFilter($word, $returnOnlyWord = false, $callback = null, $type = self::NORMAL);

    /**
    * @param string $word
    * @param string $patternWord
    * @param mixed $essentialGrammems
    * @param bool $returnOnlyWord
    * @param mixed $callback
    * @param mixed $type
    * @return array
    */
    function castFormByPattern($word, $patternWord, phpMorphy_GrammemsProvider_GrammemsProviderInterface $grammemsProvider = null, $returnOnlyWord = false, $callback = null, $type = self::NORMAL);
}