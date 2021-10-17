<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_Dict_Source_Mrd implements phpMorphy_Dict_Source_SourceInterface {
    protected
        $manager;

    function __construct($mwzFilePath) {
        $this->manager = $this->createMrdManager($mwzFilePath);
    }

    protected function createMrdManager($mwzPath) {
        $manager = new phpMorphy_Aot_MrdManager();
        $manager->open($mwzPath);

        return $manager;
    }

    function getName() {
        return 'mrd';
    }

    // phpMorphy_Dict_Source_SourceInterface
    function getLanguage() {
        $lang = strtolower($this->manager->getLanguage());

        switch($lang) {
            case 'russian':
                return 'ru_RU';
            case 'english':
                return 'en_EN';
            case 'german':
                return 'de_DE';
            default:
                return $this->manager->getLanguage();
        }
    }

    function getDescription() {
        return 'Dialing dictionary file for ' . $this->manager->getLanguage() . ' language';
    }

    function getAncodes() {
        return $this->manager->getGramInfo();
    }

    function getFlexias() {
        return $this->manager->getMrd()->flexias_section;
    }

    function getPrefixes() {
        return $this->manager->getMrd()->prefixes_section;
    }

    function getAccents() {
        return $this->manager->getMrd()->accents_section;
    }

    function getLemmas() {
        return $this->manager->getMrd()->lemmas_section;
    }
}