<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_Dict_Source_Xml_Section_Prefixes extends phpMorphy_Dict_Source_Xml_SectionAbstract {
    protected
        $current;

    protected function getSectionName() {
        return 'prefixes';
    }

    function rewind() {
        $this->current = null;

        parent::rewind();
    }

    protected function readNext(XMLReader $reader) {
        do {
            if($this->isStartElement('prefix_model')) {
                $prefix_model = new phpMorphy_Dict_PrefixSet($reader->getAttribute('id'));

                while($this->read()) {
                    if($this->isStartElement('prefix')) {
                            $prefix_model->append($reader->getAttribute('value'));
                    } elseif($this->isEndElement('prefix_model')) {
                        break;
                    }
                }

                unset($this->current);
                $this->current = $prefix_model;

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