<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_Aot_GramTab_GramInfoFactory {
    const GRAMMEMS_SEPARATOR = ',';
    const UNKNOWN_PART_OF_SPEECH_TAG = '*';
    
    /** @var phpMorphy_Aot_GramTab_GramInfoHelperInterface */
    protected $helper;

    /**
     * @param phpMorphy_Aot_GramTab_GramInfoHelperInterface $helper
     */
    function __construct(phpMorphy_Aot_GramTab_GramInfoHelperInterface $helper) {
        $this->helper = $helper;
    }

    /**
     * @param string $partOfSpeech
     * @param string $grammems
     * @param string $ancode
     * @return phpMorphy_Aot_GramTab_GramInfo
     */
    function create($partOfSpeech, $grammems, $ancode) {
        $grammems = $this->parseGrammems($grammems);
        $partOfSpeech = $this->helper->convertPartOfSpeech($partOfSpeech, $grammems);

        return new phpMorphy_Aot_GramTab_GramInfo(
            $this->parsePartOfSpeech($partOfSpeech),
            $grammems,
            $ancode,
            $this->helper->isPartOfSpeechProductive($partOfSpeech)
        );
    }

    /**
     * @param string $partOfSpeech
     * @return string|null
     */
    protected function parsePartOfSpeech($partOfSpeech) {
        return $partOfSpeech === self::UNKNOWN_PART_OF_SPEECH_TAG ? null : $partOfSpeech;
    }
    
    /**
     * @param string $grammems
     * @return string[]
     */
    protected function parseGrammems($grammems) {
        $default = mb_internal_encoding();
        mb_internal_encoding('utf-8');

        $grammems = array_map(
            'mb_strtolower',
            array_unique(
                array_values(
                    array_filter(
                        array_map(
                            'trim',
                            explode(self::GRAMMEMS_SEPARATOR, $grammems)
                        ),
                        'strlen'
                    )
                )
            )
        );

        mb_internal_encoding($default);

        return $grammems;
    }
}