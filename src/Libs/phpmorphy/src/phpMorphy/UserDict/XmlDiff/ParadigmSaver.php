<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */


class phpMorphy_UserDict_XmlDiff_ParadigmSaver {
    /** @var phpMorphy_Dict_Source_Mutable */
    private $source;

    function __construct(phpMorphy_Dict_Source_Mutable $source) {
        $this->source = $source;
    }

    /**
     * @param phpMorphy_Paradigm_ParadigmInterface $paradigm
     * @return phpMorphy_Dict_Lemma
     */
    function save(phpMorphy_Paradigm_ParadigmInterface $paradigm) {
        return $this->createLemma($paradigm);
    }

    /**
     * @param phpMorphy_Paradigm_ParadigmInterface $paradigm
     * @param string $base
     * @param string $additionalCommonPrefix
     * @return phpMorphy_Dict_Lemma
     */
    protected function createLemma(phpMorphy_Paradigm_ParadigmInterface $paradigm) {
        $flexia_model = $this->createFlexiaModel($paradigm);
        $base = $paradigm->getPseudoRoot();
        $common_prefix = $paradigm[0]->getCommonPrefix();

        $lemma = new phpMorphy_Dict_Lemma(
            $base,
            $flexia_model->getId(),
            null
        );

        if(strlen($common_prefix)) {
            $prefix_set = new phpMorphy_Dict_PrefixSet(null);
            $prefix_set->append($common_prefix);
            $prefix_set_id = $this->source->appendPrefix($prefix_set)->getId();
            $lemma->setPrefixId($prefix_set_id);
        }

        if(count($paradigm->getCommonGrammems())) {
            $common_ancode = $this->createAncode(null, $paradigm->getCommonGrammems());
            $lemma->setAncodeId($common_ancode->getId());
        }

        return $this->source->appendLemma($lemma);
    }

    /**
     * @param phpMorphy_Paradigm_ParadigmInterface $paradigm
     * @return phpMorphy_Dict_FlexiaModel
     */
    protected function createFlexiaModel(phpMorphy_Paradigm_ParadigmInterface $paradigm) {
        $flexia_model = new phpMorphy_Dict_FlexiaModel(null);

        foreach($paradigm->getAffixes() as $affix) {
            $ancode = $this->createAncode($affix['pos'], $affix['grammems']);

            $flexia = new phpMorphy_Dict_Flexia(
                $affix['prefix'],
                $affix['suffix'],
                $ancode->getId()
            );

            $flexia_model->append($flexia);
        }

        return $this->source->appendFlexiaModel($flexia_model);
    }

    /**
     * @param string $partOfSpeech
     * @param string[] $grammems
     * @return phpMorphy_Dict_Ancode
     */
    protected function createAncode($partOfSpeech, $grammems) {
        $ancode = new phpMorphy_Dict_Ancode(
            null,
            $partOfSpeech,
            false,
            $grammems
        );

        return $this->source->appendAncode($ancode);
    }
}