<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */


class phpMorphy_Generator_PhpFileParser_Exception extends Exception {
    function __construct($msg, array $token = null) {
        $msg = null === $token ? $msg : $msg . ', at ' . $token[2] . ' line';

        parent::__construct($msg);
    }
}