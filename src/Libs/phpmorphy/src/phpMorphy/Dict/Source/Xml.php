<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_Dict_Source_Xml implements phpMorphy_Dict_Source_SourceInterface {
    protected
        $xml_file,
        $locale;

    function __construct($xmlFile) {
        $this->xml_file = $xmlFile;

        foreach(new phpMorphy_Dict_Source_Xml_Section_Options($xmlFile) as $key => $value) {
            if('locale' === $key) {
                $this->locale = $value;
                break;
            }
        }

        if(!strlen($this->locale)) {
            throw new Exception("Can`t find locale in '{$xmlFile}' file");
        }
    }

    function getName() {
        return 'morphyXml';
    }

    function getLanguage() {
        return $this->locale;
    }

    function getDescription() {
        return "Morphy xml file '{$this->xml_file}'";
    }

    function getAncodes() {
        return new phpMorphy_Dict_Source_Xml_Section_Ancodes($this->xml_file);
    }

    function getFlexias() {
        return new phpMorphy_Dict_Source_Xml_Section_Flexias($this->xml_file);
    }

    function getPrefixes() {
        return new phpMorphy_Dict_Source_Xml_Section_Prefixes($this->xml_file);
    }

    function getLemmas() {
        return new phpMorphy_Dict_Source_Xml_Section_Lemmas($this->xml_file);
    }

    function getAccents() {
        // HACK: all lemmas points to accent model with 0 index and length = 4096
        $accent_model = new phpMorphy_Dict_AccentModel(0);
        $accent_model->import(new ArrayIterator(array_fill(0, 4096, null)));

        return new ArrayIterator(array( 0 => $accent_model));
    }
}