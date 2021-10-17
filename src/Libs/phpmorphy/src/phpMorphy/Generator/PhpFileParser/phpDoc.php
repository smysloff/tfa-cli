<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

class phpMorphy_Generator_PhpFileParser_phpDoc {
    public
        /** @var string */
        $text,
        /** @var int */
        $startLine,
        /** @var int */
        $endLine;

    /**
     * @param array $token
     */
    function __construct($token) {
        $this->startLine = $token[2];
        $this->endLine = $this->startLine + substr_count($token[1], "\n");
        $this->text = $token[1];
    }
}