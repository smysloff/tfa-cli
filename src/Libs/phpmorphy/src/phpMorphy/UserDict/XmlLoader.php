<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */



class phpMorphy_UserDict_XmlLoader {
    private
        /* @var phpMorphy_UserDict_VisitorInterface */
        $visitor,
        /* @var phpMorphy_UserDict_EncodingConverter */
        $encoding_converter;

    /**
     * @param phpMorphy_UserDict_VisitorInterface $visitor
     * @param phpMorphy_UserDict_EncodingConverter $encodingConverter
     */
    private function __construct(
        phpMorphy_UserDict_VisitorInterface $visitor,
        phpMorphy_UserDict_EncodingConverter $encodingConverter
    ) {
        $this->visitor = $visitor;
        $this->encoding_converter = $encodingConverter;
    }

    /**
     * @param string $filePath
     * @param phpMorphy_UserDict_VisitorInterface $visitor
     * @param phpMorphy_UserDict_EncodingConverter $encodingConverter
     */
    static function loadFromFile(
        $filePath,
        phpMorphy_UserDict_VisitorInterface $visitor,
        phpMorphy_UserDict_EncodingConverter $encodingConverter
    ) {
        $that = new phpMorphy_UserDict_XmlLoader($visitor, $encodingConverter);
        $that->load($filePath, $visitor, false);
    }

    /**
     * @param string $xmlString
     * @param phpMorphy_UserDict_VisitorInterface $visitor
     * @param phpMorphy_UserDict_EncodingConverter $encodingConverter
     */
    static function loadFromString(
        $xmlString,
        phpMorphy_UserDict_VisitorInterface $visitor,
        phpMorphy_UserDict_EncodingConverter $encodingConverter
    ) {
        $that = new phpMorphy_UserDict_XmlLoader($visitor, $encodingConverter);
        return $that->load($xmlString, true);
    }

    /**
     * @param string $filePathOrXmlString
     * @param bool $firstArgIsFile
     */
    private function load($filePathOrXmlString, $firstArgIsFile) {
        // TODO: Use XmlReader
        $dom = new DOMDocument();

        $method = $firstArgIsFile ? 'load' : 'loadXML';
        $dom->$method($filePathOrXmlString, LIBXML_NOBLANKS | LIBXML_NOCDATA);

        $root = $dom->firstChild;

        foreach($root->childNodes as $node) {
            if($node->nodeType == XML_ELEMENT_NODE) {
                $node_name = $node->nodeName;
                $method_name = "on{$node_name}Command";
                $this->$method_name($node);
            }
        }
    }

    /**
     * @param DOMNode $node
     */
    private function onAddCommand(DOMNode $node) {
        $lexem = $this->normalizeEncoding($this->getAttribute($node, 'lexem'));

        $pattern = new phpMorphy_UserDict_Pattern(
            $this->normalizeEncoding($this->getAttribute($node, 'template')),
            phpMorphy_UserDict_GrammarIdentifier::constructFromPosAndGrammems(
                $this->normalizeEncoding($this->getAttribute($node, 'template-pos', false, null)),
                $this->normalizeEncoding($this->getAttribute($node, 'template-grammems', false, ''))
            )
        );

        $this->visitor->addLexem($lexem, $pattern);
    }

    /**
     * @param DOMNode $node
     */
    private function onDeleteCommand(DOMNode $node) {
        $pattern = new phpMorphy_UserDict_Pattern(
            $this->normalizeEncoding($this->getAttribute($node, 'lexem')),
            phpMorphy_UserDict_GrammarIdentifier::constructFromPosAndGrammems(
                $this->normalizeEncoding($this->getAttribute($node, 'lexem-pos', false, null)),
                $this->normalizeEncoding($this->getAttribute($node, 'lexem-grammems', false, ''))
            )
        );

        $from = strtolower($this->getAttribute($node, 'from', false, 'both'));
        $delete_from_internal = ($from === 'internal' || $from === 'both');
        $delete_from_external = ($from === 'external' || $from === 'both');

        $this->visitor->deleteLexem($pattern, $delete_from_internal, $delete_from_external);
    }

    /**
     * @param DOMNode $node
     */
    private function onEditCommand(DOMNode $node) {

    }

    /**
     * @param string $string
     * @return string
     */
    private function normalizeEncoding($string) {
        return $this->encoding_converter->toInternal($string);
    }

    /**
     * @staticvar array $true_values
     * @param string $value
     * @return bool
     */
    private function parseFlagValue($value) {
        static $true_values = array(
            'true',
            '1',
            'y',
            'yes'
        );

        return in_array(strtolower($value), $true_values);
    }

    /**
     *
     * @param DOMElement $element
     * @param string $name
     * @param bool $throwIfNotExists
     * @param mixed $default
     * @return string
     */
    private function getAttribute(DOMElement $element, $name, $throwIfNotExists = true, $default = null) {
        $node = null;
        if(!$element->hasAttributes() || null === ($node = $element->attributes->getNamedItem($name))) {
            if($throwIfNotExists) {
                throw new DOMException("Attribute with '$name' not found in " . $this->nodeName . " node");
            } else {
                return $default;
            }
        }

        return $node->nodeValue;
    }
}