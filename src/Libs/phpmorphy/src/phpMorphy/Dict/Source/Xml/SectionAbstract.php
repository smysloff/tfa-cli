<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

abstract class phpMorphy_Dict_Source_Xml_SectionAbstract implements Iterator {
    private
        $reader,
        $section_name,
        $xml_file;

    function __construct($xmlFile) {
        $this->xml_file = $xmlFile;
        $this->section_name = $this->getSectionName();
    }

    private function createReader() {
        $reader = new XMLReader();
        if(false === ($reader->open($this->xml_file))) {
            throw new Exception("Can`t open '$this->xml_file' xml file");
        }

        return $reader;
    }

    private function closeReader() {
        $this->reader->close();
        $this->reader = null;
    }

    private function getReader($section) {
        $reader = $this->createReader();

        while($reader->read()) {
            if($reader->localName === 'options') {
                break;
            }
        }

        if($section !== 'options') {
            if(false === ($reader->next($section))) {
                //throw new Exception("Can`t seek to '$section' element in '{$this->xml_file}' file");
            }
        }

        return $reader;
    }

    function current() {
        return $this->getCurrentValue();
    }

    function next() {
        $this->readNext($this->reader);
        /*
        if($this->valid()) {
            $this->read();
        }
        */
    }

    function key() {
        return $this->getCurrentKey();
    }

    function rewind() {
        if(!is_null($this->reader)) {
            $this->reader->close();
        }

        $this->reader = $this->getReader($this->section_name);

        $this->next();
    }

    function valid() {
        return !is_null($this->reader);
    }

    protected function read() {
        if(
            !$this->reader->read() ||
            ($this->reader->nodeType == XMLReader::END_ELEMENT && $this->reader->localName === $this->section_name)
        ) {
            $this->closeReader();
            return false;
        }

        return true;
    }

    protected function isStartElement($name) {
        return $this->reader->nodeType == XMLReader::ELEMENT && $this->reader->localName === $name;
    }

    protected function isEndElement($name) {
        return
            ($this->reader->nodeType == XMLReader::ELEMENT || $this->reader->nodeType == XMLReader::END_ELEMENT)&&
            $this->reader->localName === $name;
    }

    abstract protected function getSectionName();
    abstract protected function readNext(XMLReader $reader);
    abstract protected function getCurrentKey();
    abstract protected function getCurrentValue();
}