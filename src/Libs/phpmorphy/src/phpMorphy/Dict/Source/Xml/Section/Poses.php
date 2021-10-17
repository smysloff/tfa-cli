<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_Dict_Source_Xml_Section_Poses extends phpMorphy_Dict_Source_Xml_SectionAbstract {
    protected
        $current;

    protected function getSectionName() {
        return 'poses';
    }

    function rewind() {
        $this->current = null;

        parent::rewind();
    }

    protected function readNext(XMLReader $reader) {
        do {
            if($this->isStartElement('pos')) {
                $this->current = array(
                    'id' => (int)$reader->getAttribute('id'),
                    'name' => $reader->getAttribute('name'),
                    'is_predict' => (bool)$reader->getAttribute('is_predict')
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