<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

interface phpMorphy_Paradigm_ParadigmInterface extends Countable, ArrayAccess, IteratorAggregate {
    /**
     * Alias for getLemma()
     * @see phpMorphy_Paradigm_ParadigmInterface::getLemma()
     * @abstract
     * @return string
     */
    function getBaseForm();

    /**
     * Returns lemma for this paradigm
     * @abstract
     * @return string
     */
    function getLemma();

    /**
     * Returns longest common substring for all word forms in this paradigm
     * @abstract
     * @return string
     */
    function getPseudoRoot();

    /**
     * Returns all unique word forms for this paradigm
     * @abstract
     * @return string[]
     */
    function getAllForms();

    /**
     * Returns word form at given position in paradigm
     * @abstract
     * @param int $index
     * @return void
     */
    function getWordForm($index);
}