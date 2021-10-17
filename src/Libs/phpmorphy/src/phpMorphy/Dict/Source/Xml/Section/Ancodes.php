<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_Dict_Source_Xml_Section_Ancodes extends phpMorphy_Dict_Source_Xml_SectionAbstract {
    protected
        $poses,
        $grammems,

        $current;

    function __construct($xmlFile) {
        $this->poses = iterator_to_array(new phpMorphy_Dict_Source_Xml_Section_Poses($xmlFile));
        $this->grammems = iterator_to_array(new phpMorphy_Dict_Source_Xml_Section_Grammems($xmlFile));

        parent::__construct($xmlFile);
    }

    protected function getSectionName() {
        return 'ancodes';
    }

    function rewind() {
        $this->current = null;

        parent::rewind();
    }

    protected function readNext(XMLReader $reader) {
        do {
            if($this->isStartElement('ancode')) {
                $pos_id = (int)$reader->getAttribute('pos_id');

                if(!isset($this->poses[$pos_id])) {
                    throw new Exception("Invalid pos id '$pos_id' found in ancode '" . $reader->getAttribute('id') . "'");
                }

                $pos = $this->poses[$pos_id];

                $ancode = new phpMorphy_Dict_Ancode(
                    $reader->getAttribute('id'),
                    $pos['name'],
                    $pos['is_predict']
                );

                while($this->read()) {
                    if($this->isStartElement('grammem')) {
                        $grammem_id = (int)$reader->getAttribute('id');

                        if(!isset($this->grammems[$grammem_id])) {
                            throw new Exception("Invalid grammem id '$grammem_id' found in ancode '" . $ancode->getId() . "'");
                        }

                        $ancode->addGrammem($this->grammems[$grammem_id]['name']);
                    } elseif($this->isEndElement('ancode')) {
                        break;
                    }
                }

                unset($this->current);
                $this->current = $ancode;

                break;
            }
        } while($this->read());
    }

    protected function getCurrentKey() {
        return $this->current->getId();
    }

    protected function getCurrentValue() {
        return $this->current;
    }
}