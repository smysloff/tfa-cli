<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */


class phpMorphy_UserDict_XmlDiff_Generator implements phpMorphy_UserDict_VisitorInterface {

    const MATCH_ONLY_LEMMAS = true;
    const USE_COMMON_PREFIXES_FOR_NEW_LEMMA = true;
    const DELETE_UNUNSED_MODELS_ON_SAVE = true;

    protected
        /** @var phpMorphy_UserDict_EncodingConverter */
        $encoding_converter,
        /** @var phpMorphy_UserDict_LogInterface */
        $log,
        /** @var phpMorphy_Dict_Source_Mutable */
        $source,
        /** @var phpMorphy_MorphyInterface */
        $morphy,
        /** @var phpMorphy_Dict_Ancode */
        $part_of_speech_for_deleted,
        /** @var phpMorphy_UserDict_PatternMatcher */
        $pattern_matcher
        ;

    /**
     * @param phpMorphy_MorphyInterface $morphy
     * @param phpMorphy_UserDict_LogInterface $log
     * @param phpMorphy_UserDict_EncodingConverter $encodingConverter
     */
    function __construct(
        phpMorphy_MorphyInterface $morphy,
        phpMorphy_UserDict_LogInterface $log,
        phpMorphy_UserDict_EncodingConverter $encodingConverter
    ) {
        $this->morphy = $morphy;
        $this->source = $this->createMutableSource($morphy);

        $this->encoding_converter = $encodingConverter;
        $this->log = $log;

        $this->pattern_matcher = $this->createPatternMatcher();

        $this->add_command = new phpMorphy_UserDict_XmlDiff_Command_Add(
            $encodingConverter,
            $this->pattern_matcher,
            $morphy
        );

        //$this->delete_command = new phpMorphy_UserDict_XmlDiff_Command_Delete();
    }

    /**
     * @param string $inputXmlFilePath
     * @param string $outputXmlFilePath
     * @param phpMorphy_MorphyInterface $morphy
     * @param phpMorphy_UserDict_LogInterface $observer
     * @param phpMorphy_UserDict_EncodingConverter $encodingConverter
     */
    static function convertFromXmlToXml(
        $inputXmlFilePath,
        $outputXmlFilePath,
        phpMorphy_MorphyInterface $morphy,
        phpMorphy_UserDict_LogInterface $observer,
        phpMorphy_UserDict_EncodingConverter $encodingConverter
    ) {
        $that = new phpMorphy_UserDict_XmlDiff_Generator(
            $morphy,
            $observer,
            $encodingConverter
        );

        $that->loadFromXml($inputXmlFilePath);

        $that->save(new phpMorphy_Dict_Writer_Xml($outputXmlFilePath));
    }

    /**
     * @param string $xmlFilePath
     */
    function loadFromXml($xmlFilePath) {
        phpMorphy_UserDict_XmlLoader::loadFromFile(
            $xmlFilePath,
            $this,
            $this->encoding_converter
        );
    }

    /**
     * @param phpMorphy_Dict_Writer_WriterInterface $writer
     */
    function save(phpMorphy_Dict_Writer_WriterInterface $writer) {
        if(self::DELETE_UNUNSED_MODELS_ON_SAVE) {
            $this->source->deleteUnusedModels();
        }

        $writer->write($this->source);
    }

    function clear() {
        $this->source->clearModels();
    }

    /**
     * @param phpMorphy_MorphyInterface $morphy
     * @return phpMorphy_Dict_Source_Mutable
     */
    protected function createMutableSource(phpMorphy_MorphyInterface $morphy) {
        $source = new phpMorphy_Dict_Source_Mutable();
        $source->setLanguage($morphy->getLocale());

        return $source;
    }

    protected function createPatternMatcher() {
        return new phpMorphy_UserDict_PatternMatcher();
    }

    /**
     * @param string $newLexem
     * @param phpMorphy_UserDict_Pattern $pattern
     */
    function addLexem($newLexem, phpMorphy_UserDict_Pattern $pattern) {
        return $this->add_command->execute($newLexem, $pattern, $this->log);
    }

    /**
     * @param phpMorphy_UserDict_Pattern $pattern
     * @param bool $deleteFromInternal
     * @param bool $deleteFromExternal
     */
    public function deleteLexem(phpMorphy_UserDict_Pattern $pattern, $deleteFromInternal, $deleteFromExternal) {
        $this->delete_command->execute($pattern, $deleteFromInternal, $deleteFromExternal, $this->log);
    }

    public function editLexem(phpMorphy_UserDict_XmlDiff_Command_Edit $command) {
    }
}