<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

interface phpMorphy_Dict_Source_SourceInterface {
    /**
     * @return string
     */
    function getName();
    /**
     * ISO3166 country code separated by underscore(_) from ISO639 language code
     * ru_RU, uk_UA for example
     * @return string
     */
    function getLanguage();
    /**
     * Any string
     * @return string
     */
    function getDescription();

    /**
     * @return Iterator over objects of phpMorphy_Dict_Ancode
     */
    function getAncodes();
    /**
     * @return Iterator over objects of phpMorphy_Dict_FlexiaModel
     */
    function getFlexias();
    /**
     * @return Iterator over objects of phpMorphy_Dict_PrefixSet
     */
    function getPrefixes();
    /**
     * @return Iterator over objects of phpMorphy_Dict_AccentModel
     */
    function getAccents();
    /**
     * @return Iterator over objects of phpMorphy_Dict_Lemma
     */
    function getLemmas();
}