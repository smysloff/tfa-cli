<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_Dict_Source_Xml_Section_Grammems extends phpMorphy_Dict_Source_Xml_SectionAbstract {
    protected
        $current;

    protected function getSectionName() {
        return 'grammems';
    }

    function rewind() {
        $this->current = null;

        parent::rewind();
    }

    protected function readNext(XMLReader $reader) {
        do {
            if($this->isStartElement('grammem')) {
                $this->current = array(
                    'id' => (int)$reader->getAttribute('id'),
                    'name' => $reader->getAttribute('name')
                );

                $this->read();

                break;
            }
        } while($this->read());
    }

    protected function getCurrentKey() {
        return $this->current['id'];
    }

    protected function getCurrentValue() {
        return $this->current;
    }
}