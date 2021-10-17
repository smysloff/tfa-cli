<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_Dict_Source_Xml_Section_Lemmas extends phpMorphy_Dict_Source_Xml_SectionAbstract {
    protected
        $count,
        $current;

    protected function getSectionName() {
        return 'lemmas';
    }

    function rewind() {
        $this->count = 0;
        $this->current = null;

        parent::rewind();
    }

    protected function readNext(XMLReader $reader) {
        do {
            if($this->isStartElement('lemma')) {
                unset($this->current);

                $this->current = new phpMorphy_Dict_Lemma(
                    $reader->getAttribute('base'),
                    $reader->getAttribute('flexia_id'),
                    0
                );

                $prefix_id = $reader->getAttribute('prefix_id');
                $ancode_id = $reader->getAttribute('ancode_id');

                if(!is_null($prefix_id)) {
                    $this->current->setPrefixId($prefix_id);
                }

                if(!is_null($ancode_id)) {
                    $this->current->setAncodeId($ancode_id);
                }

                $this->count++;

                $this->read();

                break;
            }
        } while($this->read());
    }

    protected function getCurrentKey() {
        return $this->count - 1;
    }

    protected function getCurrentValue() {
        return $this->current;
    }
}