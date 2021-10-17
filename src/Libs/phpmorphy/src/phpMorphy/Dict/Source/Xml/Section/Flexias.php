<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_Dict_Source_Xml_Section_Flexias extends phpMorphy_Dict_Source_Xml_SectionAbstract {
    protected
        $current;

    protected function getSectionName() {
        return 'flexias';
    }

    function rewind() {
        $this->current = null;

        parent::rewind();
    }

    protected function readNext(XMLReader $reader) {
        do {
            if($this->isStartElement('flexia_model')) {
                $flexia_model = new phpMorphy_Dict_FlexiaModel($reader->getAttribute('id'));

                while($this->read()) {
                    if($this->isStartElement('flexia')) {
                            $flexia_model->append(
                                new phpMorphy_Dict_Flexia(
                                    $reader->getAttribute('prefix'),
                                    $reader->getAttribute('suffix'),
                                    $reader->getAttribute('ancode_id')
                                )
                            );
                    } elseif($this->isEndElement('flexia_model')) {
                        break;
                    }
                }

                unset($this->current);
                $this->current = $flexia_model;

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