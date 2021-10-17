<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

abstract class phpMorphy_Morphier_MorphierAbstract implements phpMorphy_Morphier_MorphierInterface {
    protected
        /**
         * @var phpMorphy_Finder_FinderInterface
         */
        $finder,
        /**
         * @var phpMorphy_Helper
         */
        $helper;

    function __construct(phpMorphy_Finder_FinderInterface $finder, phpMorphy_Helper $helper) {
        $this->finder = $finder;

        $this->helper = clone $helper;
        $this->helper->setAnnotDecoder($finder->getAnnotDecoder());
    }

    /**
     * @return phpMorphy_Finder_FinderInterface
     */
    function getFinder() {
        return $this->finder;
    }

    /**
     * @return phpMorphy_Helper
     */
    function getHelper() {
        return $this->helper;
    }

    function getAnnot($word) {
        if(false === ($annots = $this->finder->findWord($word))) {
            return false;
        }

        return $this->helper->decodeAnnot($annots, true);
    }

    function getParadigmCollection($word) {
        if(false === ($annots = $this->finder->findWord($word))) {
            return false;
        }

        return $this->helper->getParadigmCollection($word, $annots);
    }

    function getAllFormsWithAncodes($word) {
        if(false === ($annots = $this->finder->findWord($word))) {
            return false;
        }

        return $this->helper->getAllFormsWithResolvedAncodes($word, $annots);
    }

    function getPartOfSpeech($word) {
        if(false === ($annots = $this->finder->findWord($word))) {
            return false;
        }

        return $this->helper->getPartOfSpeech($annots);
    }

    function getBaseForm($word) {
        if(false === ($annots = $this->finder->findWord($word))) {
            return false;
        }

        return $this->helper->getBaseForm($word, $annots);
    }

    function getPseudoRoot($word) {
        if(false === ($annots = $this->finder->findWord($word))) {
            return false;
        }

        return $this->helper->getPseudoRoot($word, $annots);
    }

    function getAllForms($word) {
        if(false === ($annots = $this->finder->findWord($word))) {
            return false;
        }

        return $this->helper->getAllForms($word, $annots);
    }

    function getAncode($word) {
        if(false === ($annots = $this->finder->findWord($word))) {
            return false;
        }

        return $this->helper->getAncode($annots);
    }

    function getGrammarInfo($word) {
        if(false === ($annots = $this->finder->findWord($word))) {
            return false;
        }

        return $this->helper->getGrammarInfo($annots);
    }

    function getGrammarInfoMergeForms($word) {
        if(false === ($annots = $this->finder->findWord($word))) {
            return false;
        }

        return $this->helper->getGrammarInfoMergeForms($annots);
    }

    function castFormByGramInfo($word, $partOfSpeech, $grammems, $returnOnlyWord = false, $callback = null) {
        if(false === ($annots = $this->finder->findWord($word))) {
            return false;
        }

        return $this->helper->castFormByGramInfo($word, $annots);
    }

    function castFormByPattern($word, $patternWord, $returnOnlyWord = false, $callback = null) {
        if(false === ($orig_annots = $this->finder->findWord($word))) {
            return false;
        }

        if(false === ($pattern_annots = $this->finder->findWord($patternWord))) {
            return false;
        }

        return $this->helper->castFormByPattern(
            $word, $orig_annots,
            $patternWord, $pattern_annots,
            $returnOnlyWord,
            $callback
        );
    }
};