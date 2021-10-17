<?php
/*
 *  This file is part of the Term Frequency Analyzer.
 *
 *  (c) Alexander Smyslov <kokoc.smyslov@yandex.ru>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

interface phpMorphy_UnicodeHelper_UnicodeHelperInterface {
    /**
     * @abstract
     * @param string $string
     * @return int
     */
    function getFirstCharSize($string);

    /**
     * @abstract
     * @param string $string
     * @return string
     */
    function strrev($string);

    /**
     * @abstract
     * @param string $string
     * @return string
     */
    function clearIncompleteCharsAtEnd($string);

    /**
     * @abstract
     * @param string $string
     * @return int
     */
    function strlen($string);
}