<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_Paradigm_ArrayBased
    extends phpMorphy_Util_Collection_ArrayBased
    implements phpMorphy_Paradigm_ParadigmInterface
{
    /**
     * @param null|phpMorphy_Paradigm_ParadigmInterface $paradigm
     */
    function __construct(phpMorphy_Paradigm_ParadigmInterface $paradigm = null) {
        if(null !== $paradigm) {
            foreach($paradigm as $wf) {
                $this->append($wf);
            }
        }
    }

    function updateCommonData() {
        $this->updateBases();
        $this->updateCommonGrammems();
    }

    protected function updateBases() {
        $words = array();
        foreach($this as $wf) {
            $words[$wf->getFormPrefix() . $wf->getBase() . $wf->getSuffix()] = 1;
        }

        $new_base = phpMorphy_Util_String::getLongestCommonSubstring(array_keys($words));

        foreach($this as $wf) {
            $word = $wf->getFormPrefix() . $wf->getBase() . $wf->getSuffix();

            if(false !== $new_base) {
                if(false === ($base_pos = strpos($word, $new_base))) {
                    throw new phpMorphy_Exception("Can`t rebase '$word' word to '$new_base' new base");
                }

                $wf->setFormPrefix(substr($word, 0, $base_pos));
                $wf->setBase($new_base);
                $wf->setSuffix(substr($word, $base_pos + strlen($new_base)));
            } else {
                $wf->setFormPrefix('');
                $wf->setBase('');
                $wf->setSuffix($word);
            }
        }
    }

    protected function updateCommonGrammems() {
        $grammems_ary = array();
        foreach($this as $wf) {
            $grammems_ary[] = $wf->getGrammems();
        }

        $common_grammems = call_user_func_array('array_intersect', $grammems_ary);
        $has_common_grammems = count($common_grammems) > 0;

        foreach($this as $wf) {
            $old_grammems = $wf->getGrammems();
            if($has_common_grammems) {
                $wf->setCommonGrammems($common_grammems);
                $wf->setFormGrammems(array_diff($old_grammems, $common_grammems));
            } else {
                $wf->setCommonGrammems(array());
                $wf->setFormGrammems($old_grammems);
            }
        }
    }

    /**
     * Returns word form at given position in paradigm
     * @param int $index
     * @return void
     */
    function getWordForm($index) {
        return $this->offsetGet($index);
    }

    /**
     * Returns all unique word forms for this paradigm
     * @return void
     */
    function getAllForms() {
        $result = array();

        foreach($this as $wf) {
            $result[$wf->getWord()] = 1;
        }

        return array_keys($result);
    }

    /**
     * Returns longest common substring from all word forms in this paradigm
     * @return string
     */
    function getPseudoRoot() {
        return $this[0]->getBase();
    }

    /**
     * Returns lemma for this paradigm
     * @return string
     */
    function getLemma() {
        return $this[0]->getWord();
    }

    /**
     * Alias for getLemma()
     * @see phpMorphy_Paradigm_ParadigmInterface::getLemma()
     * @return string
     */
    function getBaseForm() {
        return $this->getLemma();
    }
}