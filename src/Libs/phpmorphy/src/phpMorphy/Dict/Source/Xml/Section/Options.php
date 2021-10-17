<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_Dict_Source_Xml_Section_Options extends phpMorphy_Dict_Source_Xml_SectionAbstract {
    protected
        $current;

    protected function getSectionName() {
        return 'options';
    }

    protected function readNext(XMLReader $reader) {
        do {
            if($this->isStartElement('locale')) {
                if(!$this->current = $reader->getAttribute('name')) {
                    throw new Exception('Empty locale name found');
                }

                $this->read();

                break;
            }
        } while($this->read());
    }

    function rewind() {
        $this->current = null;

        parent::rewind();
    }

    protected function getCurrentKey() {
        return 'locale';
    }

    protected function getCurrentValue() {
        return $this->current;
    }
}